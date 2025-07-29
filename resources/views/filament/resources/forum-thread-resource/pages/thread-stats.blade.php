<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Thread Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Thread Statistics: {{ $this->record->title }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-800 rounded-lg">
                            <x-heroicon-o-heart class="w-6 h-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">Total Likes</p>
                            <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $this->record->likes_count }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                            <x-heroicon-o-eye class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Views</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $this->record->views_count }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg">
                            <x-heroicon-o-users class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Unique Views</p>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $this->record->unique_views_count }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg">
                            <x-heroicon-o-calendar class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Created</p>
                            <p class="text-sm font-bold text-purple-900 dark:text-purple-100">{{ $this->record->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>

            <div class="flex flex-wrap gap-3">
                <x-filament::button
                    wire:click="toggleLike"
                    :color="$this->record->isLikedByCurrentUser() ? 'danger' : 'gray'"
                    icon="heroicon-o-heart"
                >
                    {{ $this->record->isLikedByCurrentUser() ? 'Unlike' : 'Like' }} Thread
                </x-filament::button>
            </div>
        </div>

        <!-- Daily Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Views Chart -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daily Views (Last 30 Days)</h3>

                @if(count($viewStats) > 0)
                    <div class="space-y-2">
                        @foreach(array_slice($viewStats, -7) as $stat)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($stat->date)->format('M d') }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        @php
                                            $maxViews = max(array_column($viewStats, 'views'));
                                            $percentage = $maxViews > 0 ? ($stat->views / $maxViews) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $stat->views }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No view data available</p>
                @endif
            </div>

            <!-- Likes Chart -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daily Likes (Last 30 Days)</h3>

                @if(count($likeStats) > 0)
                    <div class="space-y-2">
                        @foreach(array_slice($likeStats, -7) as $stat)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($stat->date)->format('M d') }}</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        @php
                                            $maxLikes = max(array_column($likeStats, 'likes'));
                                            $percentage = $maxLikes > 0 ? ($stat->likes / $maxLikes) * 100 : 0;
                                        @endphp
                                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $stat->likes }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No like data available</p>
                @endif
            </div>
        </div>

        <!-- Popular Threads -->
        @if(count($popularThreads) > 0)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Popular Threads (By Likes)</h3>

                <div class="space-y-3">
                    @foreach($popularThreads as $thread)
                        @if($thread->id !== $this->record->id)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $thread->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">by {{ $thread->user->name }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <x-heroicon-o-heart class="w-4 h-4 text-red-500" />
                                        <span class="text-sm font-medium">{{ $thread->likes_count }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <x-heroicon-o-eye class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-medium">{{ $thread->views_count }}</span>
                                    </div>
                                    <x-filament::button
                                        size="sm"
                                        color="primary"
                                        tag="a"
                                        href="{{ ForumThreadResource::getUrl('view', ['record' => $thread]) }}"
                                    >
                                        View
                                    </x-filament::button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- User's Liked Threads -->
        @if(count($userLikedThreads) > 0)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Liked Threads</h3>

                <div class="space-y-3">
                    @foreach($userLikedThreads as $thread)
                        @if($thread->id !== $this->record->id)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $thread->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">by {{ $thread->user->name }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <x-heroicon-o-heart class="w-4 h-4 text-red-500" />
                                        <span class="text-sm font-medium">{{ $thread->likes_count }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <x-heroicon-o-eye class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-medium">{{ $thread->views_count }}</span>
                                    </div>
                                    <x-filament::button
                                        size="sm"
                                        color="primary"
                                        tag="a"
                                        href="{{ ForumThreadResource::getUrl('view', ['record' => $thread]) }}"
                                    >
                                        View
                                    </x-filament::button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
