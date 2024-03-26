$(() => {
  const repeatPeriodSec = 30;

  // Идентификатор попытки прохождения теста
  const resultId = getResultId();
  if (!resultId) {
    return;
  }
  restoreAllMachinesInput();
  setInterval(saveAllMachinesInput, repeatPeriodSec * 1000);

  function getResultId() {
    const resultIdInput = document.querySelector('input#result_id');
    if (!resultIdInput) {
      return null;
    }
    return +resultIdInput.value;
  }

  function restoreAllMachinesInput() {
    const obj = localStorage.getItem('machines-autosave');
    if (!obj) {
      return;
    }
    const parsed = JSON.parse(obj);
    if (parsed.resultId !== resultId) {
      localStorage.removeItem('machines-autosave');
      return;
    }
    window.mt2List.importData(parsed.mt2);
    window.ham2List.importData(parsed.ham2);
    console.log('loaded-machines-autosaved-data');
  }

  function saveAllMachinesInput() {
    const mt2Data = window.mt2List.getExportData();
    const ham2Data = window.ham2List.getExportData();
    const obj = {
      resultId: resultId,
      mt2: mt2Data,
      ham2: ham2Data
    };
    localStorage.setItem('machines-autosave', JSON.stringify(obj));
    console.log('machines-autosave');
  }
});
