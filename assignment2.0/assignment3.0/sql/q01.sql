SELECT distinct(fldCourseName) FROM tblEnrolls,tblCourses WHERE pmkCourseId = fnkCourseId and fldGrade = '100' order by fldCourseName
