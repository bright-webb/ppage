import axios from 'axios';
import HSSelect from '@preline/select';

declare global {
  interface Window {
    axios: typeof axios;
  }
}

interface HSSelect {
  on(event: string, callback: (e: CustomEvent) => void): void;
}

declare global {
  interface Window {
    HSSelect: {
      getInstance(el: HTMLElement): HSSelect;
    };
    Livewire: any;
  }
}