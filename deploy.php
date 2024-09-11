<?php
// Exit the script if any command fails
function executeCommand($command): void
{
    echo "Executing: $command\n";
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("pipe", "w"),  // stdout
        2 => array("pipe", "w")   // stderr
    );
    $process = proc_open($command, $descriptorspec, $pipes);
    if (is_resource($process)) {
        while ($s = fgets($pipes[1])) {
            echo $s;
            flush();
        }
        while ($s = fgets($pipes[2])) {
            echo $s;
            flush();
        }
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $return_value = proc_close($process);
        if ($return_value !== 0) {
            die("Error executing command: $command\n");
        }
    }
}

// Define variables
$dockerImage = "jcsmithf22/time-manager"; // Replace with your image name and registry
$imageTag = date('YmdHis'); // Tag the image with a timestamp (optional but useful)
$sshUser = "root"; // Replace with your SSH user
$sshHost = "5.161.89.247"; // Replace with your server's IP address or domain
$remoteProjectPath = "/root"; // Replace with the path to your project on the server

// Function to run SSH commands
function runSSHCommands()
{
    global $sshUser, $sshHost, $remoteProjectPath;

    echo "Deploying the new version on the server...\n";
    $sshCommands = [
        "cd $remoteProjectPath",
        "docker compose -f compose.yaml -f compose.prod.yaml pull",
        "docker compose -f compose.yaml -f compose.prod.yaml up -d --wait",
        "echo \"Cleaning up unused Docker images and containers...\"",
        "docker image prune -f",
        "docker container prune -f",
        "docker volume prune -f"
    ];
    $sshCommand = 'ssh -tt ' . $sshUser . '@' . $sshHost . ' "' . implode(' && ', $sshCommands) . '"';
    executeCommand($sshCommand);
    echo "Deployment and cleanup completed successfully!\n";
}

// Check if the script is called with the 'ssh' argument
if (isset($argv[1]) && $argv[1] === 'ssh') {
    runSSHCommands();
} else {
    // Full deployment process
    echo "Building JavaScript assets...\n";
    executeCommand("npm run build");

    echo "Building the Docker image...\n";
    executeCommand("docker compose -f compose.yaml -f compose.prod.yaml build --no-cache");

    echo "Removing the public/build folder...\n";
    executeCommand("rm -rf public/build");

    echo "Tagging and pushing the Docker image to the registry...\n";
    executeCommand("docker tag $dockerImage $dockerImage:$imageTag");
    executeCommand("docker push $dockerImage:$imageTag");
    executeCommand("docker push $dockerImage");

    echo "SSH into server and updating Docker Compose files...\n";
    executeCommand("scp compose.yaml compose.prod.yaml $sshUser@$sshHost:$remoteProjectPath/");

    // Run SSH commands
    runSSHCommands();
}
