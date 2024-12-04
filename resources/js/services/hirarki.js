
 
export const getParentDepartmentHirarki = (departments, currentParentId, targetParentId) => {

    if (currentParentId === targetParentId || currentParentId === null) {
    return [];
    }


    const currentDepartment = departments.find((dept) => dept.detail_department.id === currentParentId);

    if (!currentDepartment) {
      return [];
    }

    const parentHierarchy = getParentDepartmentHirarki(departments, currentDepartment.detail_department.parent_id, targetParentId);

    return [currentDepartment, ...parentHierarchy];
  };

export const getChildrenDepartmentHirarki = (
    departments,
    currentParentId,
    targetParentId
  ) => {
    if (currentParentId === targetParentId) {
      console.log("sudah cocok");
      return [];
    }
  
    const matchingDepartments = departments.filter(
      (dept) => dept.detail_department.parent_id === currentParentId
    );
  
    // console.log(matchingDepartments);
    if (matchingDepartments.length === 0) {
      // console.log("sudah matching");
      return [];
    }
  
    const childDepartments = matchingDepartments.map((dept) => ({
      ...dept,
      children: getChildrenDepartmentHirarki(
        departments,
        dept.detail_department.id,
        targetParentId
      ),
    }));
  
    return childDepartments;
  };
  