document.addEventListener('DOMContentLoaded', () => {
  let moreBtns = document.querySelectorAll('.fa-circle-chevron-down');
  let parentRows = document.querySelectorAll('.parent-row');

  moreBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const parentRow = btn.closest('.parent-row');
      if (parentRow.classList.contains('active-parent')) {
        unShowChilds(parentRow);
      } else {
        showChilds(parentRow);
      }
      
    })
  })




  function showChilds(parentRow) {
      parentRow.classList.add('active-parent');
      childRows = getChildRows(parentRow);
      childRows.forEach(row => row.style.display='table-row');
    
  }

  function unShowChilds(parentRow) {
    parentRow.classList.remove('active-parent');
    childRows = getChildRows(parentRow);
    childRows.forEach(row => row.style.display='none');

  }


 function getChildRows(parentRow) {
      let rows = [];
      let current = parentRow.nextElementSibling;

      while (current && !current.classList.contains('parent-row')) {
          rows.push(current);
          current = current.nextElementSibling;
      }
      return rows;
    }






})