<?php

use Stringy\Stringy;

/**
 * Вспомогательные функции для работы со строками
 */
class String extends Stringy
{
    /**
     * @var array символы для зачистки
     */
    private static $_symbols = array(
        ',', '.', '!', '?', ';', ':', '@', '#', '№', '%', '&',
        '*', '(', ')', '-', '+', '\\', '|', '/', '<', '>', '~',
        '`', '"', '\'', '[', ']', '=',
    );

    /**
     * @var array стоп слова для вырезки
     */
    private static $_stopWords = array(
        'а', 'без', 'более', 'бы', 'был', 'была', 'были', 'было', 'быть', 'в', 'вам', 'вас', 'весь', 'во', 'вот', 'все',
        'всего', 'всех', 'вы', 'где', 'да', 'даже', 'для', 'до', 'его', 'ее', 'если', 'есть', 'еще', 'же', 'за', 'здесь',
        'и', 'из', 'из-за', 'или', 'им', 'их', 'к', 'как', 'как-то', 'ко', 'когда', 'кто', 'ли', 'либо', 'мне',
        'может', 'мы', 'на', 'надо', 'наш', 'не', 'него', 'нее', 'нет', 'ни', 'них', 'но', 'ну', 'о', 'об', 'однако',
        'он', 'она', 'они', 'оно', 'от', 'очень', 'по', 'под', 'при', 'с', 'со', 'так', 'также', 'такой', 'там', 'те',
        'тем', 'то', 'того', 'тоже', 'той', 'только', 'том', 'ты', 'тут', 'у', 'уже', 'хотя', 'чего', 'чей', 'чем', 'что',
        'чтобы', 'чье', 'чья', 'эта', 'эти', 'это', 'я'
    );

    /**
     * Преобразование текста неправильный раскладки
     *
     * @static
     * @param string $inp
     * @return string
     */
    public static function badkeyb($inp)
    {
        return strtr($inp, array(
            '`' => 'ё', 'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш',
            'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'ё' => '`', 'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r',
            'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'a' => 'ф',
            's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж',
            "'" => 'э', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k',
            'д' => 'l', 'ж' => ';', 'э' => "'", 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т',
            'm' => 'ь', ',' => 'б', '.' => 'ю', '/' => '.', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b',
            'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', '.' => '/', '~' => 'Ё', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У',
            'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '{' => 'Х', '}' => 'Ъ',
            'Ё' => '~', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I',
            'Щ' => 'O', 'З' => 'P', 'Х' => '{', 'Ъ' => '}', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П',
            'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ':' => 'Ж', '"' => 'Э', '|' => '/', 'Ф' => 'A', 'Ы' => 'S',
            'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ':', 'Э' => '"',
            '/' => '|', 'Z' => 'Я', 'X' => 'Ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', '<' => 'Б',
            '>' => 'Ю', '?' => ',', 'Я' => 'Z', 'Ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M',
            'Б' => '<', 'Ю' => '>', ',' => '?'));
    }


    /**
     * Creates a Stringy object and assigns both str and encoding properties
     * the supplied values. If $encoding is not specified, it defaults to
     * mb_internal_encoding(). It then returns the initialized object.
     *
     * @param   string $str String to modify
     * @param   string $encoding The character encoding
     * @return  $this  A Stringy object
     */
    public static function create($str, $encoding = null)
    {
        return new static($str, $encoding);
    }


    /**
     * @param string|null $allowed
     * @return $this
     */
    public function normalize($allowed = null)
    {
        $text = $this->clean($allowed)->str;
        if (strlen($text) == 0) {
            return null;
        }

        // 1. убираем html
        $text = strip_tags($text);

        // 4. заменяем переносы строк на пробелы
        $text = str_replace(array("\r", "\n"), ' ', $text);

        // 5. удаляем стоп слова
        $regex = '/\b(?:(' . implode('|', self::$_stopWords) . '))\b/iu';
        $text = preg_replace($regex, ' ', $text);

        // 6. удаляем все цифры
        $text = preg_replace('/\d+/', ' ', $text);

        // 7. удаляем двойные проблемы
        $text = preg_replace('/\s+/u', ' ', $text);

        // 8. удаляем пробелы
        $text = trim($text);

        $text = mb_strtolower($text, $this->encoding);

        return self::create($text, $this->encoding);
    }


    /**
     * Clean string from all symbols expect literal and numbers
     *
     * @param string|null $allowed
     * @return $this
     */
    public function clean($allowed = null)
    {
        $stringy = self::create($this->str, $this->encoding);

        $stringy->str = str_replace('ё', 'е', $stringy->str);
        $stringy->str = preg_replace("/[^A-Za-zа-я0-9{$allowed}]/iu", ' ', $stringy->str);
        $stringy->str = preg_replace('/\s+/iu', ' ', $stringy->str);
        $stringy->str = trim($stringy->str);

        return $stringy;
    }

    public function hash()
    {
        return md5($this->normalize());
    }

    public function removeStopWords()
    {
        $regex = '/\b(?:(' . implode('|', self::$_stopWords) . '))\b/iu';
        return self::create(preg_replace($regex, ' ', $this->str), $this->encoding);
    }

    /**
     * Создает урл из названия
     *
     * @param string $string
     * @return string
     */
    public static function createSlug($string)
    {
        $string = trim($string);
        $string = str_replace(array_keys(self::$_symbols), array_values(self::$_symbols), $string);

        $slug = strtolower(str_replace(self::$_cyr, self::$_lat, $string));
        return trim(preg_replace('/\-+/', '-', $slug), '-');
    }

    public static function cleanText($string)
    {
        return self::myTrim(preg_replace('/[^\d+A-Za-z-Ääßüö\s]/i', '', $string));
    }

    /**
     * Gets integer value from string
     *
     * @param string $string
     * @return int|null
     */
    public static function intFromString($string)
    {
        if (preg_match('/(\d+)/', $string, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }

    public static function myTrim($string)
    {
        $string = trim($string);
        $string = trim($string, implode('', array_keys(self::$_symbols)));

        return $string;
    }
}
