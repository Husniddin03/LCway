<x-layout>
    <x-slot:title>
        Rasimlarni tahrirlash
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
        <div x-data="{ sectionTitle: `{{ $LearningCenter->name }}`, sectionTitleText: `{{ $LearningCenter->name }}ga yangi rasimlar yuklang!` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b">
                </h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>


        </div>
        <!-- Section Title End -->

        <div class="i va bb ye ki xn wq jb mo">
            <div class="tc uf sn tf rn un zf xl:gap-10">
                <div class="animate_top w-full mn/5 to/3 vk sg hh sm yh rq i pg">
                    <!-- Bg Shapes -->
                    <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h la x wd" />
                    <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h la ma ne kf" />

                    <div class="fb">
                        <h4 class="wj kk wm cc">{{ $LearningCenter->name }}</h4>
                        <p><a href="#!">{{ $LearningCenter->type }}</a></p>
                    </div>
                    <span class="rc nd rh tm lc fb"></span>

                    <div>
                        <h4 class="wj kk wm qb">Bog'lanish</h4>
                        <ul class="tc wf fg">
                            @foreach ($LearningCenter->connections as $connection)
                                @if ($connection->connection->name == 'Phone')
                                    <li style="display: flex; align-items: center; gap: 8px;">
                                        <a href="tel:{{ $connection->url }}" class="tc wf xf yd ad rg ml il ih wk">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z" />
                                            </svg>

                                        </a>
                                    </li>
                                @elseif($connection->connection->name == 'Email')
                                    <li>
                                        <a href="mailto:{{ $connection->url }}" class="tc wf xf yd ad rg ml il ih wk">
                                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/gmail.svg"
                                                width="20" height="20"
                                                alt="{{ $connection->connection->name }}" />
                                        </a>
                                    </li>
                                @elseif($connection->connection->name == 'Website')
                                    <li>
                                        <a href="{{ $connection->url }}" class="tc wf xf yd ad rg ml il ih wk">
                                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/googlechrome.svg"
                                                width="20" height="20"
                                                alt="{{ $connection->connection->name }}" />
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $connection->url }}" class="tc wf xf yd ad rg ml il ih wk">
                                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg"
                                                width="20" height="20"
                                                alt="{{ $connection->connection->name }}" />
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="animate_top w-full nn/5 vo/3 vk sg hh sm yh tq">
                    <div class="wc qf _b pn dg animate_right">
                        @foreach ($LearningCenter->images as $image)
                            <div>
                                <a href="{{ asset('storage/' . $image->image) }}" data-fslightbox
                                    class="animate_right">
                                    <img style="width: 100%; border-radius: 15px; margin-top: -20px"
                                        src="{{ asset('storage/' . $image->image) }}" alt="Blog" />
                                </a>
                                <form action="{{ route('course.deleteImage', $image->id) }}" method="post"
                                    onsubmit="return confirm('Rostdan ham rasimni o‘chirilsinmi?');">
                                    @csrf
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30"
                                            height="30" viewBox="0 0 48 48">
                                            <path fill="#f44336"
                                                d="M44,24c0,11-9,20-20,20S4,35,4,24S13,4,24,4S44,13,44,24z">
                                            </path>
                                            <line x1="16.9" x2="31.1" y1="16.9" y2="31.1"
                                                fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4">
                                            </line>
                                            <line x1="31.1" x2="16.9" y1="16.9" y2="31.1"
                                                fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="4">
                                            </line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <form class="bc" action="{{ route('course.storeImages', ['id' => $LearningCenter->id]) }}"
                        method="POST" enctype="multipart/form-data" class="fb">
                        @csrf

                        <div class="to">
                            <label class="rc ac" for="image">Rasimlar yuklang</label>
                            <input type="file" name="images[]" id="images"
                                class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" accept="image/*" multiple>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="tc xf bc">
                            <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                style="background-color: dimgray; margin-right: 5px"
                                class="vc rg lk gh ml il hi gi _l">Orqaga</a>
                            <button type="submit" class="vc rg lk gh ml il hi gi _l">Saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->
</x-layout>
