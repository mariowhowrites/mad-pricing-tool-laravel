<div class="flex flex-col items-center">
    <h1>Upload your image here</h1>
    <input id="image-input" type="file" wire:model="image">
    @error('image') <span class="error">{{ $message }}</span> @enderror

    @if ($image && $errors->isEmpty())
        <img id="image-preview" src="{{ $image->temporaryUrl() }}" height="200" width="200">

        <button wire:click="addToCart">Add to Cart</button>
    @endif

</div>

