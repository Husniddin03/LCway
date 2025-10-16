<x-layout>

    <x-slot:title>

        404 Not Found - FindCourse

    </x-slot>

    <!-- ===== 404 Start ===== -->
    <section class="i pg fh rm ej np er fj op fr">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h j k">
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h l m">
        <img src="{{ asset('images/shape-17.svg') }}" alt="Shape" class="h n o">
        <img src="{{ asset('images/shape-18.svg') }}" alt="Shape" class="h p q">

        <div class="animate_top bb xe rj">
            <img src="{{ asset('images/404.svg') }}" alt="404" class="bb fb" />

            <h2 class="ek tj eo kk wm gb">Kechirasiz, sahifa topilmadi </h2>
            <p class="hb">Siz qidirayotgan sahifa ko'chirilgan, o'chirilgan yoki mavjud emas. 
            </p>

            <a href="{{ route('index') }}" class="ek vc rg gh lk ml il _l gi hi">Asosiyga qaytish</a>
        </div>
    </section>
    <!-- ===== 404 End ===== -->

</x-layout>
