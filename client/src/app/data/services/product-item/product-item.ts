
import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';

import { Product } from '../../../models/product';
import { ProductsResponse } from '../../../models/products-response';

@Injectable({
  providedIn: 'root'
})
export class ProductItem {
  private http = inject(HttpClient);
  private baseApiUrl = 'http://localhost:8080';

  getProduct(id: number) {
    return this.http.get<Product>(
      `${this.baseApiUrl}/api/products/${id}`
    );
  }
}
