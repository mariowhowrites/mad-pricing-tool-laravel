<div x-data>
    <h1 class="text-3xl font-serif uppercase">Upload your image here</h1>
    <input id="image-input" class="hidden" type="file" wire:model="image">
    @error('image') <span class="error">{{ $message }}</span> @enderror

    <div 
        class="bg-zinc-200 border-2 border-black flex items-center text-center border-dashed h-32 w-32"
        @dragover.prevent="console.debug('dragging image into dropzone')" 
        @drop.prevent="handleImageDrop"
    >
        <label for="image-input" class="cursor-pointer">
            Browse for images
        </label>
    </div>

    @if ($image && $errors->isEmpty())
        <img id="image-preview" src="{{ $image->temporaryUrl() }}" height="200" width="200">

        <button 
            wire:click="addToCart" 
            class="bg-red-500 uppercase hover:bg-red-700 text-white px-2 py-3 shadow-md hover:shadow-lg"
        >
            Add to Cart
        </button>
        @endif
    
    <script>
        function handleImageDrop(e) {
            const files = e.dataTransfer.files

            document.querySelector('#image-input').files = files

            @this.upload('image', files[0]);
        }
    </script>
</div>

