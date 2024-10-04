import axios from 'axios';
import './bootstrap';
import Helper from './helper';
import $ from 'jquery';
import Gallery from './gallery';


document.addEventListener('DOMContentLoaded', function() {
   const gallery = new Gallery();
   const trigger = document.querySelector('[data-trigger="gallery"]') as any;
   if(trigger){
    gallery.trigger(trigger);
   }
    // Handle avatar upload
    const uploadAvatar = document.querySelector('[data-trigger="upload-avatar"]') as HTMLButtonElement;
    const uploadCover = document.querySelector('[data-trigger="upload-cover"]') as HTMLButtonElement;
    const uploadAvatarFile = document.getElementById('avatar') as HTMLInputElement;
    const coverImage = document.getElementById('coverImage') as HTMLInputElement;
    const avatarPreviewContainer = document.querySelector('[data-trigger="avatar-preview"]') as any;
    const coverImageContainer = document.querySelector('[data-trigger="cover-preview"]') as any;
    
    if(uploadAvatar){
        uploadAvatar.addEventListener('click', (e: Event) => {
            e.preventDefault();
            uploadAvatarFile.click();
        });

        uploadAvatarFile.addEventListener('change', (e: Event) => {
       
            const file = (e.target as HTMLInputElement).files?.[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                   avatarPreviewContainer.innerHTML = ""
                   const img = document.createElement('img');
                   img.src = event.target?.result as string;
                   img.classList.add('w-full', 'object-cover', 'rounded-full')
                   img.style.height = "100%";
                   img.style.width = "100%";
                   avatarPreviewContainer.innerHTML = img.outerHTML;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle cover photo upload
   if(uploadCover){
    uploadCover.addEventListener('click', (e: Event) => {
        e.preventDefault();
        coverImage.click();
    });

    coverImage.addEventListener('change', (e: Event) => {
        const file = (e.target as HTMLInputElement).files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                coverImageContainer.innerHTML = ""
                const img = document.createElement('img');
                img.src = event.target?.result as string;
                coverImageContainer.innerHTML = img.outerHTML;
            }
            reader.readAsDataURL(file)
        }
    });
   }

});


// Handle array types
const array = document.querySelector('.add-array-item') as HTMLButtonElement;
if (array) {
    array.addEventListener('click', (e: Event) => {
        e.preventDefault();

        // Get the element that contains the array items
        const arrayItems = array.parentElement?.previousElementSibling as HTMLDivElement;

        if (arrayItems) {
            const item = arrayItems.querySelector('.array-item')?.cloneNode(true) as HTMLElement;

            if (item) {
                const inputElement = item.querySelector('input') as HTMLInputElement;
                if (inputElement) {
                    inputElement.value = '';  // Clear the input field
                }

                // Create the remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = "button";
                removeBtn.classList.add(
                    'py-2', 'px-2', 'inline-flex', 'justify-center', 'rounded-full', 
                    'items-center', 'gap-x-1', 'text-sm', 'font-semibold', 
                    'rounded-e-md', 'border-transparent', 'bg-transparent', 
                    'text-red-500', 'focus:outline-none'
                );
                removeBtn.innerHTML = `<i class="fas fa-times"></i>`;

                // Append the remove button to the cloned item
                item.appendChild(removeBtn);

                removeBtn.addEventListener('click', (e: Event) => {
                    e.preventDefault();
                    item.remove();
                });
                arrayItems.appendChild(item);
            }
        }
    });
}

const catalogContainers = document.querySelectorAll('.catalog-container');

// Function to handle image preview
function handleImagePreview(input: HTMLInputElement) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e: ProgressEvent<FileReader>) {
            const result = e.target?.result;
            if (typeof result !== 'string') return;

            const previewContainer = input.nextElementSibling;
            if (!previewContainer || !previewContainer.classList.contains('image-preview')) {
                const newPreview = document.createElement('div');
                newPreview.classList.add('image-preview', 'mt-2');
                newPreview.innerHTML = `<img src="${result}" alt="Preview" class="max-w-full h-auto max-h-40 rounded">`;
                input.parentNode?.insertBefore(newPreview, input.nextSibling);
            } else {
                previewContainer.innerHTML = `<img src="${result}" alt="Preview" class="max-w-full h-auto max-h-40 rounded">`;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to setup image preview for a catalog input set
function setupCatalogInputSet(inputSet: Element) {
    const fileInputs = inputSet.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        if (input instanceof HTMLInputElement) {
            input.addEventListener('change', function() {
                handleImagePreview(this);
            });
        }
    });
}

catalogContainers.forEach((container) => {
    // Setup existing catalog input sets
    const existingInputSets = container.querySelectorAll('.catalog-input-set');
    existingInputSets.forEach(setupCatalogInputSet);

    // Handle add catalog input
    const addButton = container.nextElementSibling as HTMLElement | null;
    if (addButton && addButton.classList.contains('add-catalog')) {
        addButton.addEventListener('click', () => {
            const catalogInputSet = container.querySelector('.catalog-input-set');
            if (!catalogInputSet) return;

            const clone = catalogInputSet.cloneNode(true) as HTMLElement;
            const removeButton = clone.querySelector('.remove-catalog');

           
            let currentIndex = Number(catalogInputSet.getAttribute('data-index') || 0) + 1;
            clone.setAttribute('data-index', currentIndex.toString());

           
            const inputs = clone.querySelectorAll('input');
            inputs.forEach((input) => {
                input.value = ''; // Clear input value
                const nameAttr = input.getAttribute('name');
                if (nameAttr) {
                    input.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${currentIndex}]`));
                }
                
                // Remove existing image preview
                const previewContainer = input.nextElementSibling;
                if (previewContainer && previewContainer.classList.contains('image-preview')) {
                    previewContainer.remove();
                }
            });

            
            setupCatalogInputSet(clone);

            // Show remove button
            removeButton?.classList.remove('hidden');

            // Append the new cloned input set
            container.appendChild(clone);
            removeButton?.addEventListener('click', function () {
                clone.remove();
            });
        });
    }

    // Handle remove catalog input
    const removeButtons = container.querySelectorAll('.remove-catalog');
    removeButtons.forEach((removeButton) => {
        removeButton.addEventListener('click', (e) => {
            if (e.target instanceof Element) {
                const catalogInputSet = e.target.closest('.catalog-input-set');
                catalogInputSet?.remove();
            }
        });
    });
});

// Instantiate helper class
const h = new Helper();


// Haneld template form submission
$('#templateForm').on('submit', function(e){
    e.preventDefault();
    const form = this as HTMLFormElement;
    const data = new FormData(form);


    $.ajax({
        url: form.action,
        type: form.method,
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.status === 200){
                alert('template uploaded');
            }
            else{
                alert('Something went wrong');
            }
        },
        error: function(error) {
           alert('Something went wrong');
        }
    });
    return false;
});

$('#submitSignUpForm').submit(function(){
    const form = document.getElementById('submitSignUpForm') as HTMLElement
    const data = $(this).serialize();
    const action = $(this).attr('action');

    $('.spin').removeClass('hidden');
    $.ajax({
        method: "POST",
        url: action,
        data: data,
        
        success: function(response){
            console.log(response.message);
            if(response.status_code === 200){
                window.location.href="/verification";
            } else{
                $('.spin').addClass('hidden');
                h.alert(form, response.message);
            }
        }, 
        error: function(){
            h.hideLoader();
            $('.spin').addClass('hidden');
            h.alert(form, 'Something went wrong');
        }
    })
    return false;
});

// Login form
$('#loginForm').on('submit', function(){
    const loginForm = document.getElementById('loginForm') as HTMLElement;
    const data = $(this).serialize();
    const action = $(this).attr('action');
    const button = $(this).find('button');
    button.prop('disabled', true);
    // Add spinner
    $('.spin').removeClass('hidden');

    // Send form data
    $.ajax({
        type: "POST",
        url: action,
        data: data,
        success: function(res){
            if(res.status_code === 200){
                window.location.href="/dashboard";
            }
            else{
                button.prop('disabled', false);
                $('.spin').addClass('hidden');
                h.alert(loginForm, res.message);
            }
        }, error: function(){
            button.prop('disabled', false);
            $('.spin').addClass('hidden');
           
        }
    });
    return false;
});

