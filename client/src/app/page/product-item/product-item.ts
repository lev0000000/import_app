
import { Component, inject, OnInit, effect } from '@angular/core';
import { DecimalPipe } from '@angular/common';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { Store } from '@ngrx/store';

import { Container } from '../../shared/container/container';
import { loadProduct } from '../../store/products/products.actions';
import {
  selectProduct,
  selectProductLoading,
  selectProductsError
} from '../../store/products/products.selectors';

@Component({
  imports: [DecimalPipe, RouterLink, Container],
  selector: 'app-product-item',
  styleUrl: './product-item.css',
  templateUrl: './product-item.html',
})
export class ProductItem implements OnInit {

  constructor() {
  effect(() => {
    console.log('Product:', this.product());
    console.log('Loading:', this.loading());
    console.log('Error:', this.error());
  });
}
  private store = inject(Store);
  private route = inject(ActivatedRoute);

  product = this.store.selectSignal(selectProduct);
  loading = this.store.selectSignal(selectProductLoading);
  error = this.store.selectSignal(selectProductsError);

  ngOnInit() {
    const id = Number(this.route.snapshot.paramMap.get('id'));
      console.log('Product ID:', id);


    if (Number.isInteger(id) && id > 0) {
      this.store.dispatch(loadProduct({ id }));
    }
  }
}
