import { Component, output } from '@angular/core';

@Component({
  imports: [],
  selector: 'app-form',
  styleUrl: './form.css',
  templateUrl: './form.html',
})
export class Form {
  fileUpload = output<File>();

  selectedFile: File | null = null;

  onSubmit(event: Event) {
    event.preventDefault();
    console.log('SUBMIT ПЕРЕХВАЧЕН');

    this.upload();
  }

  onFileSelected(e: Event) {
    const input = e.target as HTMLInputElement;
    this.selectedFile = input.files?.[0] ?? null;
  }

  upload() {
    if (!this.selectedFile) return;
    this.fileUpload.emit(this.selectedFile);
    console.log(this.selectedFile);
  }

}
