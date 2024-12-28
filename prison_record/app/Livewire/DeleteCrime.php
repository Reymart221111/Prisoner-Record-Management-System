<?php

namespace App\Livewire;

use App\Models\Crime;
use Exception;
use Livewire\Component;

class DeleteCrime extends Component
{
    public $id;
    public $page;
    public $crime_name;
    public $search;
    public $isSearchRoute;

    protected $queryString = [
        'search' => ['except' => ''],
        'crime_name' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount($id, $page = 1)
    {
        $crime = Crime::findOrFail($id);

        $this->id = $crime->id;
        $this->page = $page;
        $this->crime_name = request('crime_name');

        // Determine if the current route is a search route
        $this->isSearchRoute = $this->isCurrentRouteSearch();
    }

    public function render()
    {
        return view('livewire.delete-crime', [
            'crime' => Crime::findOrFail($this->id),
        ]);
    }

    public function deleteCrime()
    {
        try {
            $crime = Crime::findOrFail($this->id);
            $crime->delete();

            session()->flash('success', 'Deleted Successfully');

            // Prepare query parameters for redirection
            $params = $this->prepareRedirectParams();

            return $this->redirectToAppropriateRoute($params);
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    private function isCurrentRouteSearch()
    {
        return request()->route()->getName() === 'superadmin.crimes.search'
            || request()->has('crime_name')
            || str_contains(url()->previous(), '/search');
    }

    private function prepareRedirectParams()
    {
        $params = [];

        if ($this->page) {
            $params['page'] = $this->page;
        }

        if ($this->crime_name) {
            $params['crime_name'] = $this->crime_name;
        }

        return $params;
    }

    private function redirectToAppropriateRoute(array $params)
    {
        if ($this->isSearchRoute) {
            return redirect()->route('superadmin.crimes.search', $params);
        }

        return redirect()->route('superadmin.crimes.index', $params);
    }
}
