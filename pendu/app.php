<?php
/*
    Fonction principale du jeu du pendu...

    N'hésitez pas à utiliser d'autres fichiers avec les outils d'importation appropriés.

    Il se peut que vous ayez besoin d'utiliser des fonctions prédéfinies que nous n'avons pas vues.

    Voici quelques fonctions dont vous pourriez avoir besoin : 
        array_rand() : permet de sélectionner une clé de tableau aléatoirement.
        array_search() : permet de vérifier si une valeur existe dans un tableau.
        isset() : permet de vérifier si un élément existe.
        strlen() : permet de connaître le nombre de caractères présent dans une chaîne.
        strpos() : permet de savoir si un caractère est présent dans une chaîne.
        ctype_lower() : permet de vérifie qu'une chaîne est en minuscules.
        str_repeat() : permet de répéter un nombre défini de fois un même caractère.
        range() : permet de génèrer une séquence de nombres ou de caractères sous forme de tableau.

    https://www.php.net/manual/fr/
*/

function convert_array_to_str(array $tab) : string {
    return "[ " . implode(separator:" , ",array:$tab) . " ]";
}

function unpack_file(): array {
    $path_dict = __DIR__ . DS . ".." . DS . "data" . DS . "dictionnaire.json";
    $dict = file_get_contents($path_dict);
    return json_decode($dict, true);
}

function find_word(): string {
    $dict = unpack_file();
    $category_name = array_rand($dict);
    $category = $dict[$category_name];
    return $category[array_rand($category)];
}

function trying_character() {
    $letter = readline("Entrez une lettre en minuscule : ");
    if (ctype_lower($letter) && strlen($letter) == 1) {
        return [$letter, true];
    }
    return [$letter, false];
}

function create_view($word_selected): string {
    $view = "";
    $nb_char = strlen($word_selected);
    for ($iter = 1; $iter <= $nb_char; $iter++) {
        $view .= "_";
    }
    return $view;
}

function check_char(&$word_split, &$view_split, $word_lenght) {
    $entry = trying_character();
    $good = false;
    if ($entry[1]) {
        $entry = $entry[0];
        for ($iter = 0; $iter <= ($word_lenght - 1); $iter++) {
            if ($word_split[$iter] == $entry) {
                $view_split[$iter] = $entry;
                $good = true;
            }
        }
        return [$entry, $good];
    }
    else {
        echo "ce que vous avez entrez n'est pas une lettre minuscule." . PHP_EOL;
        return [$entry[1] ,false];
    }
}

function game($word, $life, $view) {
    $char_tried = [];
    $word_split = str_split($word);
    $view_split = str_split($view);
    $word_lenght = strlen($word);
    echo "Que le pendu commence !!!" . PHP_EOL;
    while ($life > 0 && $view_split != $word_split) {
        $char_tried_view = convert_array_to_str($char_tried);
        $view_split_setup = convert_array_to_str($view_split);
        echo "Vous avez $life vie(s)" . PHP_EOL . "Voici les lettres qui ont déjà été tentée : $char_tried_view " . PHP_EOL ."  $view_split_setup  :";
        $entry = check_char($word_split, $view_split, $word_lenght);
        if (!($entry[1])) {
            $life--;
            if ($entry[0] != false) {
                if (!array_search($entry[0], $char_tried)) {
                    $char_tried[] = $entry[0];
                }
            }
        }
    }
    if ($life == 0) {
        echo "Vous avez perdu. le mot était '$word'.";
    }
    elseif ($view_split == $word_split) {
        echo "Vous avez gagné. Il vous restait $life vie(s). Le mot était bien $word.";
    }
}

function start($life) {
    $word = find_word();
    $life = 10;
    $view = create_view($word);
    game($word, $life, $view);

}
?>