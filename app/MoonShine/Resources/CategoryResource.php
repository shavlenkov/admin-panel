<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use MoonShine\Decorations\Block;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class CategoryResource extends Resource
{
	public static string $model = Category::class;

	public static string $title = 'Categories';

	public function fields(): array
	{

        $categories = Category::select(['id', 'title'])->get();

        $a = [];

        foreach ($categories as $category) {
            $a[$category->id] = $category->title;
        }


        return [
            Block::make('Block title', [
                ID::make(),
                Text::make('Title', 'title'),
                Text::make('Descr', 'descr'),
                Select::make('subcategory', 'parent_id')
                    ->options($a)
            ])
        ];


	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    public function tdStyles(Model $item, int $index, int $cell): string
    {

        if ($cell === 1) {
            return 'padding-left: 200px';
        }

        return parent::tdStyles($item, $index, $cell);
    }
}
