<?php

namespace App\Jobs;

use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\AuthorLanguage;
use App\Models\SurahCombinations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SurahCombination implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $surah_id;
    public $type;
    public function __construct($surah, $type)
    {
        $this->surah_id = $surah;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = 0;
        $ayats = AlQuran::where('surah_id', $this->surah_id)->count();

        $authorLang = AuthorLanguage::pluck('_id')->all();
        foreach ($authorLang as $authLang) {
            $authLangCount =  AlQuranTranslation::where('surah_id', $this->surah_id)->where('author_lang', $authLang)->where('type', $this->type)->whereNotNull('translation')->count();

            if ($ayats != 0 && $ayats >= $authLangCount) {
                $count += 1;
            }
        }

        $surahCombination =  SurahCombinations::where('surah_id', $this->surah_id)->first();
        if ($this->type == 1) {
            $surahCombination->translation_count = $count;
        } else if ($this->type == 2) {
            $surahCombination->tafseer_count = $count;
        }
        $surahCombination->save();
        return 1;
    }
}
