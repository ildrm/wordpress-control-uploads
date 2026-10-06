export type Action = 'ALLOW' | 'SANITIZE' | 'REVIEW' | 'QUARANTINE' | 'BLOCK';
export type Condition = { group: 'AND' | 'OR' | 'NOT'; children: Condition[] } | { field: string; op: string; value?: string | number | boolean | string[] | number[] };
export type Rule = { id: string; priority: number; enabled: boolean; condition: Condition; action: Action; effects?: string[] };
export type Policy = { schema: 1; id: string; name: string; version: number; rules: Rule[]; default: Action; shadow: boolean; bands: Record<string, { review: number; block: number; calibrated: boolean }>; options: Record<string, unknown> };
export type Scan = { id: string; state: string; revision: string; file_name: string; mime: string; risk: string; created_at: string; owner_id?: string };
export type Finding = { category: string; confidence: number; provider: string; model: string; scale: string };
export function valueFromInput(op: string, input: string): string | number | boolean | string[] | number[] {
  if (['gt', 'gte', 'lt', 'lte'].includes(op)) { if (!input.trim()) throw new Error('Invalid number'); const v = Number(input); if (!Number.isFinite(v)) throw new Error('Invalid number'); return v; }
  if (op === 'between') { const parts = input.split(','); if (parts.some(v => !v.trim())) throw new Error('Invalid range'); const values = parts.map(Number); if (values.length !== 2 || values.some(v => !Number.isFinite(v)) || values[0] > values[1]) throw new Error('Invalid range'); return values; }
  if (op === 'in') return input.split(',').map(v => v.trim());
  return input;
}
export function describe(condition: Condition): string {
  if ('group' in condition) return `(${condition.children.map(describe).join(` ${condition.group} `)})`;
  return `${condition.field} ${condition.op} ${String(condition.value ?? '')}`;
}

export type BulkResult = {id: number; state?: string; error?: string};
export function bulkFailures(results: BulkResult[]): string[] { return results.filter(r => r.error).map(r => `#${r.id}: ${r.error}`); }
