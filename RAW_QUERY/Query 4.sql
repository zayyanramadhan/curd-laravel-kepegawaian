select employee.id as employee_id,employee.nik,employee.name,employee.is_active,employee_profile.gender, 
CONCAT(EXTRACT(YEAR FROM AGE(employee_profile.date_of_birth)), ' Years Old') as age, education.description as school_name, education.level, 
CASE 
    WHEN 
            SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END) = 0 AND 
            SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) = 0 AND 
            SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) = 0 AND 
            SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) = 0 THEN  
                     ' - ' 
    ELSE 	
	CASE 
        WHEN 
            SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
                CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END), ' Suami') 
            ELSE '' 
    END ||
    CASE 
        WHEN 
            SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
                CASE WHEN 
                    SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 THEN 
                        ' & ' 
                    ELSE 
                        '' 
                END || 
                CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END), ' Istri') 
            ELSE '' 
    END ||
    CASE 
        WHEN 
            SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
                CASE WHEN 
                    SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
                    SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 THEN 
                        ' & ' 
                    ELSE 
                        '' 
                END || 
                CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END), ' Anak') 
            ELSE '' 
    END ||
    CASE 
        WHEN 
            SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END) > 0 THEN 
                CASE WHEN 
                    SUM(CASE WHEN employee_family.relation_status = 'Suami' THEN 1 ELSE 0 END) > 0 OR 
                    SUM(CASE WHEN employee_family.relation_status = 'Istri' THEN 1 ELSE 0 END) > 0 OR 
                    SUM(CASE WHEN employee_family.relation_status = 'Anak' THEN 1 ELSE 0 END) > 0 THEN 
                        ' & ' 
                    ELSE 
                        '' 
                END || 
                CONCAT(SUM(CASE WHEN employee_family.relation_status = 'Anak Sambung' THEN 1 ELSE 0 END), ' Anak Sambung') 
            ELSE '' 
    END
    END AS family_data    
from employee left join education on employee.id = education.employee_id left join employee_profile on employee.id = employee_profile.employee_id left join employee_family on employee.id = employee_family.employee_id group by employee.id, employee_profile.gender, employee_profile.date_of_birth, education.description, education.level