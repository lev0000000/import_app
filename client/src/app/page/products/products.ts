
import { Component, inject, OnInit } from '@angular/core';
import { AsyncPipe } from '@angular/common';
import { RouterLink } from '@angular/router';
import { Store } from '@ngrx/store';

import { Container } from '../../shared/container/container';
import { loadProducts } from '../../store/products/products.actions';
import {
  selectAllProducts,
  selectProductsLoading,
  selectTotalPages
} from '../../store/products/products.selectors';
import { ProductsFilter } from '../../shared/products-filter/products-filter';
import { ProductFilters } from '../../models/products-filters';

@Component({
  selector: 'app-products',
  imports: [AsyncPipe, RouterLink, Container, ProductsFilter],
  templateUrl: './products.html'
})
export class Products implements OnInit {
  private store = inject(Store);

  products$ = this.store.select(selectAllProducts);
  loading$ = this.store.select(selectProductsLoading);
  totalPages$ = this.store.select(selectTotalPages);

  page = 1;
  limit = 20;

  filters: ProductFilters = {
    name: '',
    minPrice: null,
    maxPrice: null
  };

  ngOnInit() {
    this.loadProducts();
  }

  loadProducts() {
    this.store.dispatch(loadProducts({
      page: this.page,
      limit: this.limit,
      filters: this.filters
    }));
  }

  onFiltersChanged(filters: ProductFilters) {
    this.filters = filters;
    this.page = 1;
    this.loadProducts();
  }

  nextPage(totalPages: number) {
    if (this.page >= totalPages) return;

    this.page++;
    this.loadProducts();
  }

  previousPage() {
    if (this.page <= 1) return;

    this.page--;
    this.loadProducts();
  }
}
