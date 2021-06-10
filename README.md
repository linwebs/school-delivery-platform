# School Delivery Platform
Linwebs 校園送餐平台  
* Ver. 2.0  
	https://delivery.csie.linwebs.tw/  
* Socket 版本  
	https://socket.delivery.csie.linwebs.tw/

> Linwebs 2021.6  
> NCYU Database System Design  
> Network Programming Design

## 平台環境
* CentOS 8
* Apache 2.4
* MySQL 8
* PHP 7.4

## 建置框架
Linwebs PHP Framework 2021

## 環境配置
### 設定檔
* 系統設定檔  
	複製 `config/app.sample.php` 到 `config/app.php` 並修改系統設定
* 資料庫連線設定檔   
	複製 `config/database.sample.php` 到 `config/database.php` 並修改資料庫連線設定

### Socket 啟動
* TCP 5701 port  
	```sh
	php socket/tcp_multicast.php
	```
* UDP 5702 port  
	```sh
	php socket/udp_multicast.php
	```
