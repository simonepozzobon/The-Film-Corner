<?php

namespace App\Http\Controllers\Api;

use App\AppFeedback;
use App\WelcomeForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function welcome_save(Request $request)
    {
        $user = json_decode($request->user);
        $form = WelcomeForm::where([
            ['userable_id', '=', $user->id],
            ['userable_type', '=', $request->user_type],
        ])->first();

        if ($form) {
        // c'è già un form
            $form->userable_id = $user->id;
            $form->userable_type = $request->user_type;
            $form->word_1 = $request->word_1;
            $form->word_2 = $request->word_2;
            $form->word_3 = $request->word_3;
            $form->answer = $request->answer;
            $form->save();

        } else {
        // bisogna creare un nuovo form
            $form = new WelcomeForm();

            $form->userable_id = $user->id;
            $form->userable_type = $request->user_type;
            $form->word_1 = $request->word_1;
            $form->word_2 = $request->word_2;
            $form->word_3 = $request->word_3;
            $form->answer = $request->answer;
            $form->save();
        }

        return response()->json($form, 200);
    }

    public function save_feedback(Request $request)
    {
        $feedback = new AppFeedback();
        $feedback->valutation = $request->valutation;
        $feedback->comment = $request->comment;
        $feedback->userable_id = $request->user_id;
        $feedback->userable_type = $request->user_type;
        $feddback->source = $request->location;
        $feedback->save();

        return response($feedback);
    }
}
