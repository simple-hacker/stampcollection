<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="title" class="text-gray-500 font-bold p-4">Title</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="title" name="title" type="text" value="{{ old('title', $stamp->title) }}" placeholder="Title" class="w-full p-2 rounded border shadow @error('title') border-red-500 @enderror" required>
            @error('title')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
            <div class="w-1/3">
                <label for="sg_number" class="text-gray-500 font-bold p-4">Stanley Gibbons Number</label>
            </div>
            <div class="flex flex-col w-2/3">
                <input id="sg_number" name="sg_number" type="number" step="1" value="{{ old('sg_number', $stamp->sg_number) }}" placeholder="Stanley Gibbons Number" class="w-full p-2 rounded border shadow @error('sg_number') border-red-500 @enderror">
                @error('sg_number')
                    @component('components.error') {{ $message }} @endcomponent
                @enderror
            </div>
        </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="price" class="text-gray-500 font-bold p-4">Price</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $stamp->price) }}" placeholder="0.00" class="w-full p-2 rounded border shadow @error('price') border-red-500 @enderror">
            @error('price')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="description" class="text-gray-500 font-bold p-4">Description</label>
        </div>
        <div class="flex flex-col w-2/3">
            <textarea id="description" name="description" placeholder="Description" rows="8" class="w-full p-2 rounded border shadow @error('description') border-red-500 @enderror">{{ old('description', $stamp->description) }}</textarea>
            @error('description')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    @if ($stamp->issue)
        <div class="flex items-center mb-6">
            <div class="w-1/3">
                <label for="image" class="text-gray-500 font-bold p-4">Current Image</label>
            </div>
            <div class="flex">
                <img src="{{ asset($stamp->image_src) }}" alt="{{ $stamp->title }}" class="h-20">
            </div>
        </div>
    @endif
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="image" class="text-gray-500 font-bold p-4">
                Upload Image
            </label>
        </div>
        <div class="flex flex-col w-2/3">
            <input type="file" name="image" class="w-full p-2 rounded border shadow @error('image') border-red-500 @enderror">
            @error('image')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center justify-center mb-6">
        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">{{ $button_text }}</button>
    </div>
</form>