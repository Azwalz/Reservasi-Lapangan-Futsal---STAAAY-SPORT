<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        // Personal emails
        if (preg_match('/@(gmail|yahoo)\.com$/', $value)) {
            return true;
        }
        
        // Professional emails
        if (preg_match('/@(company\.com|organization\.org)$/', $value)) {
            return true;
        }
        
        // Edukasi emails
        if (preg_match('/@(student\.[a-zA-Z]+\.edu|school\.edu)$/', $value)) {
            return true;
        }
        
        // Bisnis emails
        if (preg_match('/@(company\.com|business\.co)$/', $value)) {
            return true;
        }
        
        // Departemen/Layanan emails
        if (preg_match('/@(pt[a-zA-Z0-9]+\.co\.id|cv[a-zA-Z0-9]+\.co\.id)$/', $value)) {
            return true;
        }
        
        return false;
    }

    public function message()
    {
        return 'Format email tidak valid. Hanya menerima email dengan domain tertentu (Personal: gmail.com, yahoo.com; Profesional: company.com, organization.org; Edukasi: student.university.edu, school.edu; Bisnis: company.com, business.co; Departemen/Layanan: pt[nama].co.id, cv[nama].co.id).';
    }
}