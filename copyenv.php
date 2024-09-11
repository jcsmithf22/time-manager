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
$sshUser = "root"; // Replace with your SSH user
$sshHost = "5.161.89.247"; // Replace with your server's IP address or domain
$remoteProjectPath = "/root"; // Replace with the path to your project on the server

executeCommand("scp .env.local $sshUser@$sshHost:$remoteProjectPath/");

$sshCommands = [
    "cd $remoteProjectPath",
    "mv -f .env.local .env",
];

$sshCommand = 'ssh -tt ' . $sshUser . '@' . $sshHost . ' "' . implode(' && ', $sshCommands) . '"';
executeCommand($sshCommand);

echo "Environmental variables updated successfully!\n";
