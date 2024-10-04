import axios, { AxiosResponse, AxiosError } from "axios";

type RequestCallback = (status: string, response?: any, error?: any) => void;
class Helper {
    public spinnerId: any;
   
    constructor() {
        this.spinnerId = 'spinner';
    }

    public serializeForm(formData: FormData){
        const data: {[key: string] : any} = {}
    
        formData.forEach((value, key) => {
            data[key] = value
        });
    
        return data;
    }

    public async request(url: string, method: 'GET' | 'POST', data?: any, callback?: RequestCallback){ 
        try{
            let response: AxiosResponse;
            if(method === 'POST'){
                response = await axios.post(url, data);
            }
            else {
                response = await axios.get(url);
            }

            callback && callback('success', response.data);
            
        } catch(error: any){
            // If the request fails
            const err: AxiosError = error;
            callback && callback('fail', undefined, err.response?.data || err.message);
        }
    }

    public async signUp(action: string, data: any, callback: RequestCallback){
        this.request(action, 'POST', data, callback);
    }

    showLoader() {
       const overlay = document.getElementById('overlay');
       overlay?.classList.remove('hidden');
       const animate = document.getElementById('loader');
       animate?.classList.add('inline-block');
       animate?.classList.remove('hidden');
    }

    hideLoader() {
        const overlay = document.getElementById('overlay');
        overlay?.classList.add('hidden');
        const animate = document.getElementById('loader');
        animate?.classList.remove('inline-block');
        animate?.classList.add('hidden');
    }

    public throwError(errorMessage: string, element: HTMLElement){
        const error = document.querySelectorAll('#error-alert');
        if(error.length > 0){
            error.forEach(item => {
                element.removeChild(item);
            });
        }
        const div = document.createElement('div');
        div.id = "error-alert";
        const heading = document.createElement('strong');
        const span = document.createElement('span');
        heading.classList.add('font-bold');
        span.classList.add('block', 'sm:inline');
        span.innerText = errorMessage
        heading.innerText = "Error";
        div.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative');
        div.style.marginTop = "10px";
        div.setAttribute('role', 'alert');
        div.appendChild(heading);
        div.appendChild(span); 
        element.appendChild(div);
    }

    alert(element: HTMLElement, message: string) {
        // Check if an alert already exists and remove it to avoid duplication
        const existingAlert = document.getElementById('dismiss-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const html = `<div id="dismiss-alert" class="mt-5 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500 alert" role="alert" tabindex="-1" aria-labelledby="hs-dismiss-button-label">
                            <div class="flex">
                              <div class="ms-2">
                                <h3 id="hs-dismiss-button-label" class="text-sm font-medium message">
                                 ${message}
                                </h3>
                              </div>
                              <div class="ps-3 ms-auto">
                                <div class="-mx-1.5 -my-1.5">
                                  <button type="button" class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100 dark:bg-transparent dark:text-red-600 dark:hover:bg-red-800/50 dark:focus:bg-red-800/50" id="close-alert">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M18 6 6 18"></path>
                                      <path d="m6 6 12 12"></path>
                                    </svg>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>`;
    
        element.insertAdjacentHTML('beforeend', html);
    
        const closeButton = document.getElementById('close-alert');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                const alertElement = document.getElementById('dismiss-alert');
                if (alertElement) {
                    alertElement.remove();
                }
            });
        }
    }
    
    
}

export default Helper;