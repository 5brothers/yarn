<?php

// массив с данными
$data = [
    'pagetitle' => $main_heading,
    'alias' => "$url",
    'content' => '',
    'template' => 3,
    'published' => 1,
    'parent' => $parent_id
];  

// Запис ТВ-шек тоже можеть происходить через процессор
$shopRootTV = 'tv13'; // Указываем ID ТВ-шек
$fotoTV = 'tv6';
$priceTV = 'tv1';
$brandTV = 'tv14';
$countryTV = 'tv3';
$dlinaTV = 'tv8';
$siteUrlTV = 'tv2';
$sostavTV = 'tv10';
$sostavVivodTV = 'tv12';
$vesTV = 'tv7';

$data[$shopRootTV] = $shop_root;
$data[$fotoTV] = "templates/img/parsefoto/id$res_id/$foto_name";
$data[$priceTV] = $price_result;
$data[$specForPriceTV] = $special_for_price;
$data[$brandTV] = $brand;
$data[$countryTV] = $country;
$data[$dlinaTV] = $dlina_result;
$data[$siteUrlTV] = $massa;
$data[$sostavTV] = $final_sostav_noperc;
$data[$sostavVivodTV] = $sostav_result;
$data[$vesTV] = $ves_result;
    
// выполнение процессора    
$response = $modx->runProcessor('resource/create', $data);

// если ошибка 
if($response->isError()){
//    echo "<div><b style='color:olive'>Документ не создан:</b> $main_heading</div>". $response->getMessage();
    
    // Выполняем поиск по alias 
$resource = $modx->getObject('modResource', array('alias' => "$url"));

// Если нашли ресурс
if (is_object($resource)) {
// Устанавливаем заголовок
    $resource->set('pagetitle', "$main_heading");
// Обновляем TV
    $resource->setTVValue('siteUrl', $massa);
    $resource->setTVValue('sostavVivod', $sostav_result); 
    $resource->setTVValue('sostav', $final_sostav_noperc); 
    $resource->setTVValue('price', $price_result);
    $resource->setTVValue('specForPrice', $special_for_price);
    $resource->setTVValue('foto', "templates/img/parsefoto/id$res_id/$foto_name"); 
    $resource->setTVValue('ves', $ves_result);
    $resource->setTVValue('dlina', $dlina_result);
    $resource->setTVValue('brand', $brand);
    
//  Сохранение
    $resource->save();

    
echo "<div><b style='color:olive'>Документ обновлен:</b> $main_heading</div>";
        
} else {
    echo "<div><b style='color:red'>Документ не найден:</b> $main_heading</div>";
}
    
}
else{
    echo "<div><b style='color:green'>Документ создан:</b> $main_heading</div>";
}
