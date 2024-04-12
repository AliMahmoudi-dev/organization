<x-layout>
    <div class="w-full min-h-full flex flex-col">
        <x-header />
        <div class="w-full flex-grow flex justify-center items-center">
            <div class="w-[650px] border border-gray-300 rounded-md overflow-hidden">
                <div class="bg-gray-100 text-gray-800 border-b border-gray-300 text-lg font-bold px-3.5 py-2">
                    <span>ثبت درخواست</span>
                </div>
                <div>
                    <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid px-3.5 py-5">
                            <div class="grid">

                                <div class="w-full @error('category') '' @else pb-5 @enderror">
                                    <select class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        name="category" id="category">
                                        <option value="" {{ $errors->any() ? '' : 'selected' }} hidden>انتخاب نوع
                                            هزینه کرد</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $errors->any() && $category->id == old('category') ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-error field-name="category" />
                                </div>

                                <div class="w-full @error('shaba_number') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="شماره شبا" type="text" name="shaba_number" id="shaba_number"
                                        value="{{ old('shaba_number') }}">
                                    <x-error field-name="shaba_number" />
                                </div>

                                <div class="w-full @error('amount') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="مبلغ (تومان)" type="text" name="amount" id="amount"
                                        value="{{ old('amount') }}">
                                    <x-error field-name="amount" />
                                </div>

                                <div class="w-full @error('description') '' @else pb-5 @enderror">
                                    <textarea class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5" name="description" id="description"
                                        rows="4" placeholder="توضیحات">{{ old('description') }}</textarea>
                                    <x-error field-name="description" />
                                </div>

                                <div class="w-full @error('file') '' @else pb-5 @enderror">
                                    <input type="file" name="file" id="file">
                                    <x-error field-name="file" />
                                </div>

                                <input
                                    class="border mt-2 outline-none cursor-pointer border-sky-600 bg-sky-600 py-2 px-3.5 text-lg font-bold text-white rounded-md"
                                    type="submit" value="ثبت">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
