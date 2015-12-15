select distinct S.fldFirstName, S.fldLastName, count(*), E.fldGrade from tblEnrolls E, tblStudents S, tblCourses C

where E.fnkStudentId = S.pmkStudentId and E.fnkCourseId = C.pmkCourseId and S.fldState = "VT" and E.fldGrade > (select avg(fldGrade) from tblEnrolls E, tblStudents S where E.fnkStudentId = S.pmkStudentId and S.fldState = "VT")

group by fldGrade,fldFirstName order by fldGrade desc, fldLastName, fldFirstName