<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const BUSINESS = 'Doanh nghiệp';
    const MEDICAL = 'Y tế';
    const NORMAL = 'Bình thường';

    /*  BUSINESS MEMBER    */
    const PHARMACEUTICAL_COMPANIES = 'Công ty dược phẩm';
    const HOSPITALS = 'Bệnh viện';
    const CLINICS = 'Phòng khám';
    const PHARMACIES = 'Hiệu thuốc';
    const SPAS = 'Spa';
    const OTHERS = 'Khác';

    /*  MEDICAL SERVICES    */
    const DOCTORS = 'Bác sĩ';
    const PHAMACISTS = 'Dược sĩ';
    const THERAPISTS = 'Nhà trị liệu';
    const ESTHETICIANS = 'Nhân viên thẩm mỹ';
    const NURSES = 'Y tá';

    /*  NORMAL MEMBER   */
    const PAITENTS = 'Bệnh nhân';
    const NORMAL_PEOPLE = 'Người bình thường';

    /*  ADMIN   */
    const ADMIN = 'Quản trị viên';
}
