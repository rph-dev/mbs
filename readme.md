### About

Message Broadcast System (MBS) เป็นระบบส่งข้อความ Broadcast ไปยังอุปกรณ์เคลื่อนที่ เช่น มือถือ ที่ติดตั้ง Line App

### Features

- ส่งข้อความ Broadcast ไปได้ที่ละหลายคน
- รองรับประเภท ข้อความ รูปภาพ วิดีโอ
- ผู้ใช้งานที่ เพิ่มเพื่อน และยืนยันตัวตนด้วย Code + วดป. เกิด แล้วเท่านั้น จึงจะสามารถรับข้อความ Broadcast ได้
- สามารถสร้างกลุ่มสำหรับผู้รับข้อความเฉพาะ
- สามารถเพิ่มผู้ใช้งานกลุ่มพิเศษ (ที่ไม่มี วดป. เกิด) เช่น Line ID ของหน่วยงาน หรือแผนกต่าง ๆ ภายในองค์กร
- ระบบจัดการผู้ใช้งานงานเบื้องต้น โดยสามารถ เพิ่ม แก้ไข ยกเลิกการผูก Line ID กับ ผู้ใช้งาน

### System Requirements
- Linux OS ติดตั้ง ffmpeg package
- MySQL 5.7+ or MariaDB 10.2+
- Nginx หรือ Apache Server
- Git
- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Installation
ติดตั้งด้วย Docker
1. สร้างโปรเจคและ Docker Container
```sh
$ git clone https://github.com/rph-dev/mbs
$ cd mbs
$ chmod -R +x ./docker
$ cd docker
$ ./create.sh
```
##### แก้ไข .env
1.1 ส่วน Database connection
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_mbs
DB_USERNAME=root
DB_PASSWORD=root
```

1.2 ส่วน Line Token
```
LINE_MBS_CHANNEL_ACCESS_TOKEN="xxx"
LINE_MBS_CHANNEL_SECRET="xxx"
```

2. การติดตั้ง
```sh
$ ./install.sh
```

เข้าใช้งานผ่าน
```
http://127.0.0.1:8088
```


### Bug Reports & Feature Requests
หากพบข้อผิดพาด (Programming bug) หรือคุณสมบัติอื่น ๆ ที่อยากเพิ่มเติมในอนาคต สามารถรายงานได้ที่ [GitHub Issues](https://github.com/rph-dev/mbs/issues)

### Upgrading
```sh
$ ./update.sh
```

### Contributing
ระบบ Message Broadcast System (MBS) พัฒนาด้วย Laravel Framework 5.8 และ Vue.js หากท่านมองเห็นว่ามี Code ส่วนใดเหมาะสมที่ควรแก้ไข หรือปรับปรุงเพิ่มประสิทธิภาพให้ดีขึ้น ท่านสามารถ Fork โปรเจคนี้เพื่อส่ง Pull Requests เข้ามาได้ทุกเมื่อ

### Security Vulnerabilities

หากคุณค้นพบช่องโหว่ด้านความปลอดภัยภายใน Message Broadcast System (MBS) โปรดส่งอีเมลไปที่ Kongvut Sangkla ผ่านทาง [kongvut.s@rph.co.th](mailto:kongvut.s@rph.co.th) ช่องโหว่ความปลอดภัยทั้งหมดจะได้รับการแก้ไขทันที

### License

The Message Broadcast System (MBS) is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
