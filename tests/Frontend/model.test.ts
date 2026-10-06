import {describe, it, expect} from 'vitest';
import {bulkFailures, valueFromInput, describe as describeRule} from '../../assets/src/model';
describe('Policy editor values', () => {
  it('rejects empty thresholds and incomplete ranges', () => {expect(() => valueFromInput('gte','')).toThrow(); expect(() => valueFromInput('between','1,')).toThrow();});
  it('reports individual bulk failures', () => expect(bulkFailures([{id:1,state:'ALLOWED'},{id:2,error:'QUEUE.STALE_RESULT'}])).toEqual(['#2: QUEUE.STALE_RESULT']));
  it('preserves numeric thresholds', () => expect(valueFromInput('gte','0.85')).toBe(0.85));
  it('rejects nonnumeric and reversed ranges', () => {expect(() => valueFromInput('gte','oops')).toThrow(); expect(() => valueFromInput('between','4,2')).toThrow();});
  it('parses sets and ranges', () => {expect(valueFromInput('in','media, avatar')).toEqual(['media','avatar']); expect(valueFromInput('between','1,5')).toEqual([1,5]);});
  it('shows nested conditions clearly', () => expect(describeRule({group:'AND',children:[{field:'context',op:'eq',value:'avatar'},{field:'sexual.explicit',op:'gte',value:0.85}]})).toContain('AND'));
});
