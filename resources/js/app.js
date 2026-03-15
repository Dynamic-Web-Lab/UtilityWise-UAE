// UtilityWise UAE — frontend (Phase 1: Chart.js can be added for dashboard)
// Example: consumption chart on dashboard
document.addEventListener('DOMContentLoaded', function () {
  const chartEl = document.getElementById('consumption-chart');
  if (chartEl && chartEl.dataset.months) {
    try {
      const data = JSON.parse(chartEl.dataset.months);
      if (Array.isArray(data) && data.length > 0) {
        // Placeholder: integrate Chart.js here for monthly consumption
        console.log('Consumption data:', data);
      }
    } catch (e) {
      console.warn('Chart data parse error', e);
    }
  }
});
