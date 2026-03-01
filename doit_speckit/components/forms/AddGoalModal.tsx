"use client";

import { GoalForm } from "./GoalForm";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";

interface AddGoalModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSubmit: (title: string, endDate: string) => void;
  isLoading?: boolean;
}

/**
 * Modal dialog for adding a new goal
 * Wraps GoalForm in a Dialog component
 */
export function AddGoalModal({
  isOpen,
  onClose,
  onSubmit,
  isLoading = false,
}: AddGoalModalProps) {
  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-md">
        <DialogHeader>
          <DialogTitle>Add New Goal</DialogTitle>
        </DialogHeader>
        <GoalForm
          onSubmit={onSubmit}
          onCancel={onClose}
          isLoading={isLoading}
        />
      </DialogContent>
    </Dialog>
  );
}
