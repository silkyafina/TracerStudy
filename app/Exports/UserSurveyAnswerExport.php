<?php

namespace App\Exports;

use App\Models\UserSurveyAnswer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserSurveyAnswerExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = UserSurveyAnswer::with('userSurvey.alumni.prodi');

        // SEARCH
        if ($this->request->search) {
            $query->whereHas('userSurvey.alumni', function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nim', 'like', '%' . $this->request->search . '%');
            });
        }

        // PRODI
        if ($this->request->prodi_id) {
            $query->whereHas('userSurvey.alumni', function ($q) {
                $q->where('prodi_id', $this->request->prodi_id);
            });
        }

        // TAHUN
        if ($this->request->tahun_dari) {
            $query->whereHas('userSurvey.alumni', function ($q) {
                $q->whereYear('tahun_lulus', '>=', $this->request->tahun_dari);
            });
        }

        if ($this->request->tahun_sampai) {
            $query->whereHas('userSurvey.alumni', function ($q) {
                $q->whereYear('tahun_lulus', '<=', $this->request->tahun_sampai);
            });
        }

        $answers = $query->latest()->get();

        return view('admin.user_survey_answers.export', compact('answers'));
    }
}
