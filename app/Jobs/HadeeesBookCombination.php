<?php

namespace App\Jobs;

use App\Models\AuthorLanguage;
use App\Models\Hadees;
use App\Models\HadeesBookCombination;
use App\Models\HadeesBooks;
use App\Models\HadeesTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HadeeesBookCombination implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $book_id;
    public $type;
    public function __construct($book, $type)
    {
        $this->book_id = $book;
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
        $hadith = Hadees::where('book_id', $this->book_id)->count();
        $authorLang = AuthorLanguage::pluck('_id')->all();
        foreach ($authorLang as $authLang) {
            $authLangCount =  HadeesTranslation::where('book_id', $this->book_id)->where('author_lang', $authLang)->where('type', $this->type)->whereNotNull('translation')->count();

            if ($hadith != 0 && $hadith == $authLangCount) {
                $count += 1;
            }
        }



        $hadithCombination =  HadeesBookCombination::where('book_id', $this->book_id)->first();
        if ($hadithCombination) {
            if ($this->type == 5) {
                $hadithCombination->translation_count = $count;
            } else if ($this->type == 6) {
                $hadithCombination->tafseer_count = $count;
            }
            $hadithCombination->translation_count = $count;
            $hadithCombination->save();
        } else {
            $hadithBook  = HadeesBooks::where('_id', $this->book_id)->first();
            $hadithCombination = new HadeesBookCombination();
            $hadithCombination->title = $hadithBook->title;
            $hadithCombination->book_id = $hadithBook->_id;
            $hadithCombination->description = $hadithBook->description;
            $hadithCombination->translation_count = $count;
            $hadithCombination->save();
        }

        return 1;
    }
}
