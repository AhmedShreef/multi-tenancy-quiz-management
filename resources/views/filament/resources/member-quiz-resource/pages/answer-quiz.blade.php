<x-filament-panels::page>
    <div class="space-y-6">
        <h2 class="text-xl font-bold">{{ $quiz->name }}</h2>
        <p class="text-gray-600">{{ $quiz->description }}</p>

        <form method="POST" action="{{ route('filament.admin.resources.member-quizzes.answer.submit', ['record' => $quiz->id]) }}">
            @csrf
            <div class="space-y-4">
                @foreach ($quiz->questions as $question)
                    <div class="p-4 bg-white rounded-lg shadow">
                        <p class="font-semibold text-gray-800">
                            {{ $loop->iteration }}. {{ $question->question_text }}
                        </p>
                        <div class="mt-2 space-y-2 break-inside-avoid pt-4">
                            @foreach ($question->options as $option)
                                <label class="flex gap-x-3">
                                    <input
                                        type="radio"
                                        name="answers[{{ $question->id }}]"
                                        value="{{ $option->id }}"
                                        required
                                        class="text-blue-600 focus:ring-blue-500 fi-radio-input border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-gray-400 disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10 mt-1"
                                    >

                                    <div class="grid text-sm leading-6">
				                        <span class="font-medium text-gray-950 dark:text-white">
				                            {{ $option->option_text }}
				                        </span>

				                    
				                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit" 
                class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400" style="background-color: #de7e06;">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
