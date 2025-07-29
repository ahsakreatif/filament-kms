<x-filament-widgets::widget>
    <div class="fi-wi-stats-overview-header grid gap-y-1 mb-4">
        <h3 class="fi-wi-stats-overview-header-heading col-span-full text-base font-semibold leading-6 text-gray-950 dark:text-white">
            Recommended Forum Threads
        </h3>
    </div>

    <div class="space-y-4">
        @php
            $recommendedThreads = $this->getRecommendedThreads();
            $topTags = $this->getUserTopTags();
        @endphp

        @if($topTags->isNotEmpty())
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                    Your Top Interests
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($topTags as $tag)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        @if($recommendedThreads->isNotEmpty())
            <div class="space-y-3">
                @foreach($recommendedThreads as $thread)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                    <a href="#" class="hover:text-purple-600 dark:hover:text-purple-400">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    by {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
                                </p>
                                @if($thread->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($thread->tags->take(3) as $tag)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                    </svg>
                                    {{ $thread->likes_count }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $thread->views_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm">No recommendations available yet.</p>
                    <p class="text-xs mt-1">Start liking and viewing forum threads to get personalized recommendations.</p>
                </div>
            </div>
        @endif
    </div>
</x-filament-widgets::widget>
