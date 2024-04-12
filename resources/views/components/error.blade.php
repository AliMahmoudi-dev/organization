@props(['fieldName'])
@error($fieldName)
    <div class="text-sm pt-0.5 pb-1 font-semibold text-red-700">
        {{ $message }}
    </div>
@enderror
