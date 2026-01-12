<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventViewController extends Controller
{
    /**
     * Get all events
     */
    public function index()
    {
        $events = Event::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Event list',
            'data' => $this->formatEvents($events)
        ]);
    }

    /**
     * Get single event
     */
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Event details',
            'data' => $this->formatEvent($event)
        ]);
    }

    /**
     * Filter events by type (live / upcoming)
     */
    public function byType($type)
    {
        if (!in_array($type, ['live', 'upcoming'])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid event type'
            ], 400);
        }

        $events = Event::where('event_type', $type)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => ucfirst($type).' events',
            'data' => $this->formatEvents($events)
        ]);
    }

    /**
     * Format multiple events
     */
    private function formatEvents($events)
    {
        return $events->map(function ($event) {
            return $this->formatEvent($event);
        });
    }

    /**
     * Format single event
     */
    private function formatEvent($event)
    {
        return [
            'id'          => $event->id,
            'title'       => $event->title,
            'event_date'  => $event->event_date,
            'event_type'  => $event->event_type,
            'location'    => $event->location,
            'description' => $event->description,
            'image'       => $event->image ? url('public/'.$event->image) : null,
        ];
    }
}
