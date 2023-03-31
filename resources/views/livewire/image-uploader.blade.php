<div class="flex flex-col items-center">
    <h1>Upload your image here</h1>
    <input id="image-input" type="file" wire:model="image">
    @error('image') <span class="error">{{ $message }}</span> @enderror

    @if ($image && $errors->isEmpty())
        <img id="image-preview" src="{{ $image->temporaryUrl() }}" height="200" width="200">

        <button 
            wire:click="addToCart" 
            class="bg-red-500 hover:bg-red-700 text-white px-2 py-3 rounded-lg shadow-md hover:shadow-lg"
        >
            Add to Cart
        </button>
    @endif
</div>

