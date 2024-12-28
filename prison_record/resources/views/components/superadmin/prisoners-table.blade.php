@php
use App\Enums\PrisonerStatus;
@endphp
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Prisoners List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Name</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Age</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Admission Date</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Release Date</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($prisoners as $prisoner)
                    <tr class="@if($loop->even) bg-gray-50 @else bg-white @endif hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">#{{$prisoner->prisoner_id}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$prisoner->getFullNameAttribute()}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$prisoner->getAgeAttribute()}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{$prisoner->admission_date->format('Y-m-d')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $prisoner->release_date ? $prisoner->release_date->format('Y-m-d') : 'Indefinite' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @switch($prisoner->status->value)
                            @case(PrisonerStatus::ACTIVE->value)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @break

                            @case(PrisonerStatus::ESCAPED->value)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-rose-100 text-rose-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @break

                            @case(PrisonerStatus::TRANSFERRED->value)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @break

                            @case(PrisonerStatus::RELEASED->value)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-sky-100 text-sky-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @break

                            @case(PrisonerStatus::DECEASED->value)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @break

                            @default
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($prisoner->status->value) }}
                            </span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            @livewire('prisoner-action-button', ['prisonerId' => $prisoner->id, 'page' =>
                            request()->query('page', 1)])
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination links -->
            <div class="p-4">
                {{ $prisoners->links() }}
            </div>
        </div>
    </div>
</div>