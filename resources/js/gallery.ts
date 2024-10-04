// Can't seem to fix this
// When ever I try to delete a thumbnail, it doesn't actually delete it from the Input as it creates a new input whenever...
// the dialog is opened. I'm not sure how to fix this.

export default class Gallery {
   public action!: HTMLElement;
   public thumbnails: HTMLElement | null = null;
   public inputFile: HTMLInputElement | null = null;

   constructor() {
    this.thumbnails = document.querySelector('.gallery-thumbnails');
   }
    trigger(action: HTMLElement) {
        this.action = action;
        action.addEventListener('click', () => {
            const inputFile = document.createElement('input');
            inputFile.type = 'file';
            inputFile.accept = 'image/*';
            inputFile.multiple = true;
            inputFile.click();
            inputFile.style.display = 'none';
            inputFile.name = "gallery[]";
            action.appendChild(inputFile);
            inputFile.addEventListener('change', (e: Event) => {
                const files = (e.target as HTMLInputElement).files;
                console.log(files?.length);
                if(files && files.length > 0){
                    this.showThumbs(files);
                }
            });
        });

        // Drag and drop functionality
        action.addEventListener('dragover', (e: any) => {
            e.preventDefault();
            action.classList.add('dragging');
        });

        action.addEventListener('dragleave', (e: any) => {
            e.preventDefault();
            action.classList.remove('dragging');
        });

        action.addEventListener('drop', (e: any) => {
            e.preventDefault();
            action.classList.remove('dragging');
            const files = e.dataTransfer?.files;
            if(files && files.length > 0){
                this.showThumbs(files);
            }
        });
    }

    handleDragOver(e: DragEvent) {
        e.preventDefault();
        this.action.classList.add('dragging');
    }

    handleDragLeave(e: DragEvent) {
        e.preventDefault();
        this.action.classList.remove('dragging');
    }

    handleDrop(e: DragEvent) {
        e.preventDefault();
        this.action.classList.remove('dragging');
        const files = e.dataTransfer?.files;
        if (files) {
            this.handleFiles(files);
        }
    }

    showThumbs(files: FileList){
        if(!this.thumbnails) return;

        Array.from(files).forEach((file: File) => {
          if(this.isValidFile(file)){
            const reader = new FileReader();
            reader.onload = (e: any) => {
                const imgURL = e.target.result as string;
                 const thumbnailWrapper = document.createElement('div');
                 thumbnailWrapper.classList.add('thumbnail-wrapper');
                 const img = document.createElement('img');
                 img.src = imgURL;
                 img.className = 'thumbnail';
                 
                //  const caption = document.createElement('input');
                //  caption.type = 'text';
                //  caption.placeholder = 'Add a caption';
                //  caption.className = 'caption';

                 // Delete
                 const deleteButton = document.createElement('button');
                 deleteButton.className = 'delete-button';
                 // Create trash icon
                 const icon = document.createElement('i');
                 icon.classList.add('fas', 'fa-trash-alt');
                 icon.style.fontSize = '0.5rem';
                 deleteButton.appendChild(icon);
                 deleteButton.classList.add('flex', 'shrink-0', 'justify-center', 'items-center', 'gap-2', 'size-[14px]', 'text-sm', 'font-semibold', 'text-red-500', 'rounded-lg', 'border', 'border-transparent', 'bg-red-100', 'text-white', 'hover:bg-red-200', 'focus:outline-none', 'focus:ring-200')
                 deleteButton.addEventListener('click', () => {
                    this.thumbnails?.removeChild(thumbnailWrapper);
                 });

                 // Append element to the thumbnail wrapper
                 thumbnailWrapper.appendChild(img);
                //  thumbnailWrapper.appendChild(caption);
                 thumbnailWrapper.appendChild(deleteButton);

                 // Append the thumbnail wrapper to the thumbnails container
                 this.thumbnails?.appendChild(thumbnailWrapper);
                };

                reader.readAsDataURL(file);
            }
        });
    }

    showThumb(file: File, imgURL: string) {
        if (!this.thumbnails) return;

        const thumbnailWrapper = document.createElement('div');
        thumbnailWrapper.classList.add('thumbnail-wrapper');

        // Image Element
        const img = document.createElement('img');
        img.src = imgURL;
        img.className = 'thumbnail';

        // Caption Input
        // const caption = document.createElement('input');
        // caption.type = 'text';
        // caption.placeholder = 'Add a caption';
        // caption.className = 'caption';

        // Delete Button
        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete-button';
        deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
        deleteButton.addEventListener('click', () => {
            this.thumbnails?.removeChild(thumbnailWrapper);
        });

        // Append elements to the thumbnail wrapper
        thumbnailWrapper.appendChild(img);
        // thumbnailWrapper.appendChild(caption);
        thumbnailWrapper.appendChild(deleteButton);

        // Append the thumbnail wrapper to the thumbnails container
        this.thumbnails.appendChild(thumbnailWrapper);
    }

       handleFiles(files: FileList) {
        Array.from(files).forEach((file: File) => {
            if (this.isValidFile(file)) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imgURL = (e.target as FileReader).result as string;
                    this.showThumb(file, imgURL);
                };
                reader.readAsDataURL(file);
            }
        });

        // Clear the input value after file selection to allow new files to be uploaded
        if (this.inputFile) {
            this.inputFile.value = '';
        }
    }

    // Validation to check if the file is an image
    isValidFile(file: File): boolean {
        return file.type.startsWith('image/');
    }
  
}