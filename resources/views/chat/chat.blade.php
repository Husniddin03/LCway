<x-layout>
    <x-slot:title>
        O'qituvchiga elon berish sahifasi
    </x-slot>
    <!-- ===== Contact Start ===== -->
    <section id="support" class="i pg fh rm ji gp uq">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h aa y" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h ca u" />
        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="h w da ee" />
        <img src="{{ asset('images/shape-12.svg') }}" alt="Shape" class="h p s" />
        <img src="{{ asset('images/shape-13.svg') }}" alt="Shape" class="h r q" />

        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `{{ $LearningCenter->name }}`, sectionTitleText: `{{ $LearningCenter->name }}ga yangi o'qituvchi izlayabsizmi u holda bu yerda elon bering.` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="i va bb ye ki xn wq jb mo">
            <div class="tc uf sn tf rn un zf xl:gap-10" style="align-items: center; justify-content: center;">
                <div class="animate_top w-full vk sg hh sm yh tq">
                    <p class="ai-answer">
                        <p style="color: red">IC answer</p>
                        Assalomu alaykum men sizga kasb tanlashda va unga eltuvchi yo'llarni topishda ko'maklashuvchi
                        suniy intelektman.

                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Expedita at iste ad esse
                        voluptates cupiditate, non numquam, perferendis quas optio placeat debitis, architecto
                        quaerat nemo animi aperiam doloremque corrupti ratione repudiandae temporibus! Maxime
                        corporis itaque natus numquam placeat est officiis eligendi, magni nihil quia cupiditate
                        ratione porro asperiores officia sint id ipsum praesentium odio. Vitae nam natus autem
                        architecto provident ullam! Qui quod quaerat aut, nihil ab culpa ratione dolore, iusto odit
                        harum magni doloribus labore. Quidem voluptate beatae nesciunt nulla, perferendis provident
                        aperiam deleniti temporibus sed qui rerum sit cum, odio, pariatur animi perspiciatis ducimus
                        repellendus ipsa eveniet? Fugiat.
                    </p>
                    <p class="user-question">
                        <p style="color: red">Siz</p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Expedita at iste ad esse
                        voluptates cupiditate, non numquam, perferendis quas optio placeat debitis, architecto
                        quaerat nemo animi aperiam doloremque corrupti ratione repudiandae temporibus! Maxime
                        corporis itaque natus numquam placeat est officiis eligendi, magni nihil quia cupiditate
                        ratione porro asperiores officia sint id ipsum praesentium odio. Vitae nam natus autem
                        architecto provident ullam! Qui quod quaerat aut, nihil ab culpa ratione dolore, iusto odit
                        harum magni doloribus labore. Quidem voluptate beatae nesciunt nulla, perferendis provident
                        aperiam deleniti temporibus sed qui rerum sit cum, odio, pariatur animi perspiciatis ducimus
                        repellendus ipsa eveniet? Fugiat.
                    </p>

                    <div class="tc sf yo ap zf ep qb">
                        <div class="vd to">
                            <div class="bb ye ki xn vq jb jo">
                                <div class="animate_top">
                                    <input type="text" name="name" id="fullname" placeholder="Ask ai"
                                        class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" />
                                    <button type="submit" class="h r q" style="padding: 0.5rem">
                                        <img src="https://img.icons8.com/?size=100&id=HCYq7G4siTbb&format=png&color=000000" alt="" width="44" height="44">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->
</x-layout>
