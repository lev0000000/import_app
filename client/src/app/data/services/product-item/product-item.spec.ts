import { TestBed } from '@angular/core/testing';
import { ProductItem } from './product-item';

describe('ProductItem', () => {
  let service: ProductItem;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProductItem);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
