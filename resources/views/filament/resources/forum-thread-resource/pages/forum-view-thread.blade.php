<x-filament-panels::page>
    <div class="max-w-4xl mx-auto">
        <!-- Thread Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="p-6">
                <!-- Thread Title -->
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $this->record->title }}
                </h1>

                <!-- Thread Meta -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-user-circle class="w-5 h-5" />
                        <span class="font-medium">{{ $this->record->user->name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-calendar class="w-5 h-5" />
                        <span>{{ $this->record->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-tag class="w-5 h-5" />
                        <span>{{ $this->record->topic->name }}</span>
                    </div>
                    @if($this->record->category)
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-folder class="w-5 h-5" />
                        <span>{{ $this->record->category->name }}</span>
                    </div>
                    @endif
                </div>

                <!-- Tags -->
                @if($this->record->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($this->record->tags as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                <!-- Attached Documents -->
                @if($this->record->documents->count() > 0)
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Attached Documents</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($this->record->documents as $document)
                        <a href="{{ Storage::url($document->file_path) }}" download class="inline-flex items-center gap-2 px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            <x-heroicon-o-document class="w-4 h-4" />
                            {{ $document->title }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Thread Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="p-6">
                <div class="prose prose-gray dark:prose-invert max-w-none">
                    {!! $this->record->body !!}
                </div>
            </div>
        </div>

        <!-- Comments Section with Commentions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                    Comments ({{ $this->record->comments->count() }})
                </h2>

                <!-- Commentions Comments Component -->
                <livewire:commentions::comments
                    :record="$this->record"
                    :mentionables="App\Models\User::all()"
                    :polling-interval="'10s'"
                />
            </div>
        </div>
    </div>

    <style>
        .prose {
            max-width: none;
        }
        .prose p {
            margin-bottom: 1rem;
        }
        .prose h1, .prose h2, .prose h3, .prose h4 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
        }
        .prose blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
        }
        .prose code {
            background-color: #f3f4f6;
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
        .prose pre {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
        }

        /* Commentions Custom Styling */
        .commentions-container {
            @apply space-y-4;
        }

        .commentions-container .comment {
            @apply border-l-4 border-blue-500 pl-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-r-lg;
        }

        .commentions-container .comment-header {
            @apply flex items-center gap-3 mb-2;
        }

        .commentions-container .comment-avatar {
            @apply w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium;
        }

        .commentions-container .comment-author {
            @apply font-medium text-gray-900 dark:text-white;
        }

        .commentions-container .comment-date {
            @apply text-sm text-gray-500 dark:text-gray-400;
        }

        .commentions-container .comment-content {
            @apply text-gray-700 dark:text-gray-300 ml-11;
        }

        .commentions-container .comment-form {
            @apply mt-6 pt-6 border-t border-gray-200 dark:border-gray-700;
        }

        .commentions-container .comment-form textarea {
            @apply w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white;
        }

        .commentions-container .comment-form button {
            @apply px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors;
        }

        .commentions-container .reactions {
            @apply flex items-center gap-2 mt-2 ml-11;
        }

        .commentions-container .reaction {
            @apply inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-100 dark:bg-gray-600 rounded-full hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors cursor-pointer;
        }

        .commentions-container .mention {
            @apply inline-flex items-center px-2 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full;
        }
    </style>
</x-filament-panels::page>
