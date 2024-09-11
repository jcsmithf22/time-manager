import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ["collectionContainer"];

  static values = {
    index: Number,
    prototype: String,
  };

  addCollectionElement(event) {
    const item = document.createElement('li');
    const classes = "w-full grid gap-3 md:grid-cols-9 p-3 border-t border-gray-300 -mb-3".split(' ');
    item.classList.add(...classes);
    item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
    this.collectionContainerTarget.appendChild(item);
    this.indexValue++;
  }

  remove(event) {
    event.currentTarget.closest('li').remove();
  }}
