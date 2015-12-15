SELECT T.fldFirstName, T.fldLastName,  count(S.fldFirstName) as total, T.fldSalary, T.fldSalary/count(S.fldFirstName) as IBB

FROM tblSections JOIN tblEnrolls on tblSections.fldCRN  = tblEnrolls.`fnkSectionId` 

JOIN tblStudents S on pmkStudentId = fnkStudentId JOIN tblTeachers T on tblSections.fnkTeacherNetId=pmkNetId 

WHERE fldType != "LAB" 

group by fnkTeacherNetId 

ORDER BY IBB asc