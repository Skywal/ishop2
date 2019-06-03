<?php

namespace ishop;

/**
 * Клас для кешування даних
 * Class Cache
 * @package ishop
 */
class Cache
{
    //трейт
	use TSingltone;

    /**
     * створення файлу кешу
     * @param $key ключ для хешування назви файлу щоб у всіх операційних системах відображалося вірно
     * @param $data дані які записуються у файл кешу
     * @param int $seconds час який існуватиме файл кешу
     * @return bool
     */
	public function set($key, $data, $seconds = 3600){
	    // якшо кількість секунд більша за нуль то пишемо файл
		if($seconds){
			$content['data'] = $data;

            // час, який існуватиме файл кешу після його створення починаючи від поточного моменту
			$content['end_time'] = time() + $seconds;

			// записуємо дані у файл хешуючи назву файлу для корректної взаємодії із різними операційними системами
			if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
			    // у випадку успішного запису повертаємо TRUE
				return true;
			}
		}
		return false;
	}

    /**
     * читання файлу кешу
     * @param $key ключ для пошуку файлу кешу
     * @return bool|mixed
     */
	public function get($key){
		$file = CACHE . '/' . md5($key) . '.txt';

		if(file_exists($file)){
		    //десереалізуємо дані з файлу
			$content = unserialize(file_get_contents($file));
			// якщо час існування файлу кешу ще не вичерпався то повертаємо дані з файлу
			if(time() <= $content['end_time']){
				return $content;
			}

			//видаляємо файл
			unlink($file);
		}
		return false;
	}

    /**
     * видалення файлу кешу
     * @param $key ключ для пошуку файлу кешу щоб видалити
     */
	public function delete($key){
		$file = CACHE . '/' . md5($key) . '.txt';
		if(file_exists($file)){
			unlink($file);
		}
	}
}