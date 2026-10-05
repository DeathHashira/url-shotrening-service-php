<?php

namespace Services;

use Models\Urls;
use PDOException;

class ShortningService
{
    public function __construct(
        private Urls $urlsModel
    ) {}

   public function createNewShort(string $url): array
   {
       $shortCode = $this->generateShort();

       while (true) {
           try {
               $data = [
                   "url" => $url,
                   "short_code" => $shortCode
               ];

               if ($this->urlsModel->create($data)) {
                   return [
                       "success" => true,
                       "short_code" => $shortCode
                   ];
               } else {
                   return [
                       "success" => false,
                       "error" => "Database problem!"
                   ];
               }
               break;
           } catch (PDOException $e) {
               $shortCode = $this->generateShort();
           }
       }
   }

   public function getUrl(string $shortCode): array
   {
       $conditions = ["short_code" => $shortCode];
       $res = $this->urlsModel->readByCondition($conditions);

       if (!empty($res)) {
           $this->urlsModel->updateStatById($res[0]["id"]);
           return [
               "success" => true,
               "content" => $res[0]
           ];
       } else {
           return [
               "success" => false
           ];
       }
   }

   public function updateLink(string $newUrl, string $shortCode): array
   {
       $conditions = ["short_code" => $shortCode];
       $res = $this->urlsModel->readByCondition($conditions);
       if (empty($res)) {
           return [
               "success" => false,
               "error" => "not found"
           ];
       } else {
           if ($this->urlsModel->updateById($res[0]["id"], ["url" => $newUrl])) {
               return [
                   "success" => true
               ];
           } else {
               return [
                   "success" => false,
                   "error" => "unkown"
               ];
           }
       }
   }

   public function deleteLink(string $shortCode): array
   {
       $conditions = ["short_code" => $shortCode];
       $res = $this->urlsModel->readByCondition($conditions);

       if (empty($res)) {
           return [
               "success" => false
           ];
       } else {
           $this->urlsModel->deleteById($res[0]["id"]);
           return [
               "success" => true
           ];
       }
   }

   public function getStatics($shortCode): array
   {
       $conditions = ["short_code" => $shortCode];
       $res = $this->urlsModel->readByCondition($conditions);

       if (empty($res)) {
           return [
               "success" => false
           ];
       } else {
           return [
               "success" => true,
               "content" => $res[0]
           ];
       }
   }

   private function generateShort(): string
   {
       return bin2hex(random_bytes(4));
   }
}
