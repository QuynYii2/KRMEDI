<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgoraServiceController extends Controller
{
    public function startRecording(Request $request)
    {
        $recordingService = new RecordingService();
        $response = $recordingService->startRecording($request->all());
        return response()->json($response);
    }

    public function stopRecording(Request $request)
    {
        $recordingService = new RecordingService();
        $response = $recordingService->stopRecording($request->all());
        return response()->json($response);
    }

    public function startScreenRecording(Request $request)
    {
        $recordingService = new RecordingService();
        $response = $recordingService->startScreenRecording($request->all());
        return response()->json($response);
    }

    public function stopScreenRecording(Request $request)
    {
        $recordingService = new RecordingService();
        $response = $recordingService->stopScreenRecording($request->all());
        return response()->json($response);
    }
}
