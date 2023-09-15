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
    public function __construct($surah)
    {
        $this->surah_id = $surah;
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
            $authLangCount =  AlQuranTranslation::where('surah_id', $this->surah_id)->where('author_lang', $authLang)->translation()->whereNotNull('translation')->count();

            if ($ayats != 0 && $ayats == $authLangCount) {
                $count += 1;
            }
        }

        $surahCombination =  SurahCombinations::where('surah_id', $this->surah_id)->first();
        $surahCombination->translation_count = $count;
        $surahCombination->save();
        return 1;
    }
}
