<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Traits\CanLoadRelationships;

class EventController extends Controller
{
    use CanLoadRelationships;
    /**
     * Display a listing of the resource.
     */

    public function __construct() {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Event::class, 'event');
    }

    private array $allowed = ['user', 'attendees', 'attendees.user'];
    public function index()
    {
        $query = Event::query();

        $query = $this->loadRelationships($query);

        return EventResource::collection(
            $query->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $event = Event::create($data);

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {

        $data = $request->validated();

        $event->update($data);

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete-event', $event);

        $event->delete();

        return response(status:204);
    }
}
