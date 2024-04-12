<x-layout>
    <div class="w-full min-h-full flex justify-center items-center">
        <div class="w-[650px] border border-gray-300 rounded-md overflow-hidden">
            <div class="bg-gray-100 text-gray-800 border-b border-gray-300 text-lg font-bold px-3.5 py-2">
                <span>ثبت نام</span>
            </div>
            <div>
                <form action="{{ route('register.store') }}" method="post">
                    @csrf
                    <div class="grid px-3.5 py-5">
                        <div class="grid">
                            <fieldset class="flex gap-x-5">
                                <div class="w-full @error('name') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="نام و نام خانوادگی" type="text" name="name" id="name"
                                        value="{{ old('name') }}">
                                    <x-error field-name="name" />
                                </div>

                                <div class="w-full @error('national_code') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="کد ملی" type="text" name="national_code" id="national_code"
                                        value="{{ old('national_code') }}">
                                    <x-error field-name="national_code" />
                                </div>
                            </fieldset>

                            <fieldset class="flex gap-x-5">
                                <div class="w-full @error('phone_number') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="شماره موبایل" type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number') }}">
                                    <x-error field-name="phone_number" />
                                </div>

                                <div class="w-full @error('email') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="ایمیل" type="text" name="email" id="email"
                                        value="{{ old('email') }}">
                                    <x-error field-name="email" />
                                </div>
                            </fieldset>

                            <fieldset class="flex gap-x-5">
                                <div class="w-full @error('password') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="گذرواژه" type="password" name="password" id="password">
                                    <x-error field-name="password" />
                                </div>

                                <div class="w-full @error('password_confirmation') '' @else pb-5 @enderror">
                                    <input class="w-full border outline-none border-slate-400 rounded-md py-2 px-3.5"
                                        placeholder="تکرار گذرواژه" type="password" name="password_confirmation"
                                        id="password_confirmation">
                                    <x-error field-name="password_confirmation" />
                                </div>
                            </fieldset>
                        </div>

                        <input
                            class="border mt-2 outline-none cursor-pointer border-sky-600 bg-sky-600 py-2 px-3.5 text-lg font-bold text-white rounded-md"
                            type="submit" value="ثبت نام">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
