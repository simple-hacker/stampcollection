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
            <input id="sg_number" name="sg_number" type="text" value="{{ old('sg_number', $stamp->sg_number) }}" placeholder="Stanley Gibbons Number" class="w-full p-2 rounded border shadow @error('sg_number') border-red-500 @enderror">
            @error('sg_number')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="sg_illustration" class="text-gray-500 font-bold p-4">Stanley Gibbons Illustration</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="sg_illustration" name="sg_illustration" type="text" value="{{ old('sg_illustration', $stamp->sg_illustration) }}" placeholder="Stanley Gibbons Illustration" class="w-full p-2 rounded border shadow @error('sg_illustration') border-red-500 @enderror">
            @error('sg_illustration')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="face_value" class="text-gray-500 font-bold p-4">Face Value</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="face_value" name="face_value" type="number" min="0" step="0.01" value="{{ old('face_value', $stamp->face_value) }}" placeholder="0.00" class="w-full p-2 rounded border shadow @error('face_value') border-red-500 @enderror">
            @error('face_value')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="mint_value" class="text-gray-500 font-bold p-4">Mint Value</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="mint_value" name="mint_value" type="number" min="0" step="0.01" value="{{ old('mint_value', $stamp->mint_value) }}" placeholder="0.00" class="w-full p-2 rounded border shadow @error('mint_value') border-red-500 @enderror">
            @error('mint_value')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="used_value" class="text-gray-500 font-bold p-4">Used Value</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="used_value" name="used_value" type="number" min="0" step="0.01" value="{{ old('used_value', $stamp->used_value) }}" placeholder="0.00" class="w-full p-2 rounded border shadow @error('used_value') border-red-500 @enderror">
            @error('used_value')
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
        <button type="submit" class="shadow bg-darker hover:bg-dark focus:shadow-outline focus:outline-none text-white font-bold py-3 px-5 rounded">{{ $button_text }}</button>
    </div>
</form>