<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SkillController extends BaseController {
    const LIMIT = 10;
    public function index() {
        $skillQuery = Skill::paginate(self::LIMIT);

        $data['arSkills'] = $skillQuery->keyBy('id')->toArray();
        $data['paginatePage'] = $skillQuery;

        return view('skills.index', $data);
    }

    public function add() {
        return view('skills.add');
    }

    public function edit(Request $request) {
        $data['skill'] = Skill::where('id','=',$request->id)->get()->toArray();

        return view('skills.edit', $data);
    }

    public function update(Request $request) {
        if (empty($request->skill['id'])){
            Skill::create(array(
                "name" => $request->skill['name']
            ))->id;
        } else {
            $skill = Skill::find($request->skill['id']);

            $skill->name = $request->skill['name'];

            $skill->save();
        }

        return redirect()->route('skill.index');
    }

    public function destroy(Request $request) {
        $skill = Skill::find($request->id);

        if($skill) {
            $skill->delete();
        }
        
        return redirect()->route('skill.index');
    }
}
