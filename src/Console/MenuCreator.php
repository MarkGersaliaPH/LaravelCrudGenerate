<?php
namespace Markgersaliaph\LaravelCrudGenerate\Console;

use Illuminate\Filesystem\Filesystem;

trait MenuCreator
{
    public function processMenuCreation($name){

        $menuPath = resource_path('js/Layouts/menus.jsx');
        $content = (new FileSystem())->get($menuPath);
        
        
        // Append the new menu item
        $newMenu = [
            'name' => 'New Menu Item',
            'route' => 'new.menu.route',
        ];

        
        // Use a regular expression to locate the `menus` array
        $pattern = '/const menus = (\[.*?\]);/s';
        preg_match($pattern, $content, $matches);

        if (isset($matches[1])) {
            // Decode the existing array
            $currentMenus = json_decode($matches[1], true);

            dd($currentMenus);
            // Append the new menu item
            $currentMenus[] = [
                'name' => 'New Menu Item',
                'route' => 'new.menu.route',
            ];

            // Encode the updated array
            $updatedContent = 'const menus = ' . json_encode($currentMenus, JSON_PRETTY_PRINT) . ";\n";

            // Replace the existing `menus` array with the updated one
            $newContent = preg_replace($pattern, $updatedContent, $currentContent);

            // Write the updated content back to the file
            Storage::put($filePath, $newContent);

            return response()->json(['message' => 'Menu appended successfully']);
        } 
        dd($name,$menuPath);
    }
}