<form method="POST" action="{{ $action }}">
    @csrf
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="title" class="text-gray-500 font-bold p-4">Title</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="title" name="title" type="text" value="{{ old('title', $issue->title) }}" placeholder="Title" class="w-full p-2 rounded border shadow @error('title') border-red-500 @enderror" required>
            @error('title')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="release_date" class="text-gray-500 font-bold p-4">Release Date</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="release_date" name="release_date" type="date" value="{{ old('release_date', $issue->release_date) }}" placeholder="Select Release Date" class="w-full p-2 rounded border shadow @error('release_date') border-red-500 @enderror" required>
            @error('release_date')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="monarch_id" class="text-gray-500 font-bold p-4">Monarch</label>
        </div>
        <div class="flex flex-col w-2/3">
            <select name="monarch_id" class="w-full p-2 bg-white rounded border shadow @error('monarch_id') border-red-500 @enderror">
                <option hidden selected value=""> Select a Monarch </option>
                @foreach ($monarchs as $monarch)
                    <option value="{{ $monarch->id }}" @if($monarch->id === $issue->monarch_id) selected @endif>{{ $monarch->monarch }}</option>
                @endforeach
            </select>
            @error('monarch_id')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="category" class="text-gray-500 font-bold p-4">Category</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="category" name="category" type="text" value="{{ old('category', $issue->category) }}" placeholder="Category e.g. Commemorative, Definitive" class="w-full p-2 rounded border shadow @error('category') border-red-500 @enderror">
            @error('category')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="designer" class="text-gray-500 font-bold p-4">Designer</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="designer" name="designer" type="text" value="{{ old('designer', $issue->designer) }}" placeholder="Designer" class="w-full p-2 rounded border shadow @error('designer') border-red-500 @enderror">
            @error('designer')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="printer" class="text-gray-500 font-bold p-4">Printer</label>
        </div>
        <div class="flex flex-col w-2/3">
            <input id="printer" name="printer" type="text" value="{{ old('printer', $issue->printer) }}" placeholder="Printer" class="w-full p-2 rounded border shadow @error('printer') border-red-500 @enderror">
            @error('printer')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center mb-6">
        <div class="w-1/3">
            <label for="description" class="text-gray-500 font-bold p-4">Description</label>
        </div>
        <div class="flex flex-col w-2/3">
            <textarea id="description" name="description" placeholder="Description"  rows="8" class="w-full p-2 rounded border shadow @error('description') border-red-500 @enderror">{{ old('description', $issue->description) }}</textarea>
            @error('description')
                @component('components.error') {{ $message }} @endcomponent
            @enderror
        </div>
    </div>
    <div class="flex items-center justify-center mb-6">
        <button class="shadow bg-blue-500 hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">{{ $button_text }}</button>
    </div>
</form>