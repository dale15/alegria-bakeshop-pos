<?php

namespace App\Filament\Widgets;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Product_ingredient;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductCostingTableWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->where('is_box', false)->with(['productIngredients.ingredient']))
            ->heading('Product Costing')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('productIngredients')
                    ->label('Ingredients')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->productIngredients
                            ->map(
                                fn($item) =>
                                "{$item->ingredient->name} ({$item->quantity} × ₱" .
                                    number_format($item->cost_per_unit, 2) . ")"
                            )->implode(', ');
                    })->wrap()
            ])
            ->defaultPaginationPageOption(5);
    }
}
