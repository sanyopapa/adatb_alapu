<?php
#datetime-local formátumra alakítás stringről (nap és óra kiválasztás)
function StrToDTL($original_string) {
    $datetime = date_create_from_format('d-M-y H.i.s.u', $original_string);

    if ($datetime === false) {
        return ""; // Sikertelen konverzió esetén üres stringet adjunk vissza
    }
    return $datetime->format('Y-m-d\TH:i');
}

#datetime-local formátumról string formátumra alakítás
function DTLToStr($converted_string) {
    // Átalakítjuk az adott formátumra
    $datetime = str_replace("T", " ", $converted_string) . ":00";

    // Ellenőrizzük, hogy sikerült-e a konverzió
    if ($datetime === false) {
        return ""; // Sikertelen konverzió esetén üres stringet adjunk vissza
    }

    // Eredeti string formátumra alakítása
    return $datetime;
 
}
# Szerencsétlen CLOB mező olvasására
function read_clob($field)
{
    return $field->read($field->size());
}


function DateToStr($input_date) {
    // Az eredeti formátum megadása
    $original_format = "d-M-y H.i.s.u";

    // A célformátum megadása
    $desired_format = "Y-M-d H:i";

    // Dátum- és időformátumok átalakítása
    $timestamp = DateTime::createFromFormat($original_format, $input_date);
    if ($timestamp === false) {
        return "-";
    }
    $output_date = $timestamp->format($desired_format);

    return $output_date;
}
function DateToHour($input_date) {
    // Az eredeti formátum megadása
    $original_format = "d-M-y H.i.s.u";

    // A célformátum megadása
    $desired_format = "H:i";

    // Dátum- és időformátumok átalakítása
    $timestamp = DateTime::createFromFormat($original_format, $input_date);
    if ($timestamp === false) {
        return "-";
    }
    $output_date = $timestamp->format($desired_format);

    return $output_date;
}
