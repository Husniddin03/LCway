<!-- Pagination -->
<div class="mb lo bq i ua">
    <nav>
        <ul class="tc wf xf bg">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an">
                        <svg class="th lm ml il" width="8" height="14"><path d="M2.93884 6.99999L7.88884 11.95L6.47484 13.364L0.11084 6.99999L6.47484 0.635986L7.88884 2.04999L2.93884 6.99999Z" /></svg>
                    </span>
                </li>
            @else
                <li>
                    <a class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an" href="{{ $paginator->previousPageUrl() }}">
                        <svg class="th lm ml il" width="8" height="14"><path d="M2.93884 6.99999L7.88884 11.95L6.47484 13.364L0.11084 6.99999L6.47484 0.635986L7.88884 2.04999L2.93884 6.99999Z" /></svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Page Number Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an font-bold">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an" href="{{ $paginator->nextPageUrl() }}">
                        <svg class="th lm ml il" width="8" height="14"><path d="M5.06067 7.00001L0.110671 2.05001L1.52467 0.636014L7.88867 7.00001L1.52467 13.364L0.110672 11.95L5.06067 7.00001Z" /></svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="c tc wf xf wd in zc hn rg uj fo wk xm ml il hh rm tl zm yl an">
                        <svg class="th lm ml il" width="8" height="14"><path d="M5.06067 7.00001L0.110671 2.05001L1.52467 0.636014L7.88867 7.00001L1.52467 13.364L0.110672 11.95L5.06067 7.00001Z" /></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
</div>
<!-- Pagination -->
